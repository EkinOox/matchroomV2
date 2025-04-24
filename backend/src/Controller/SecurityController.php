<?php

namespace App\Controller;

use App\Dto\User\UserPatchDTO;
use App\Entity\PasswordResetToken;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PasswordResetTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Security\Exception\TooManyRequestsException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// TODO: Penser à ajuster la route dans services.yaml pour que le lien envoyer par mail soit correct
final class SecurityController extends AbstractController
{
    public function __construct(private UserRepository $userRepository, private RateLimiterFactory $rateLimiterFactory) {}

    #[Route('/api/request-password-reset', name: 'request_password_reset', methods: ['POST'])]
    public function requestPasswordReset(Request $request, PasswordResetTokenRepository $passwordResetTokenRepository, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        if (!$email) {
            return new JsonResponse(['error' => 'L\'email est requis.'], 400);
        }

        // Générer une clé unique en fonction de l'email et de l'IP
        $clientIp = $request->getClientIp();
        $limiterKey = $email . '_' . $clientIp;

        // Appliquer le rate limiter avec la clé unique
        $limiter = $this->rateLimiterFactory->create($limiterKey);
        $limit = $limiter->consume();

        if (!$limit->isAccepted()) {
            throw new TooManyRequestsException($limit->getRetryAfter()->getTimestamp(), 'Trop de demandes de réinitialisation de mot de passe. Veuillez réessayer dans :');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$user->isVerified() !== null) {
            // Ne pas révéler si l'email existe ou non
            return new JsonResponse(['message' => 'Si un compte existe, un email de réinitialisation a été envoyé.'], 200);
        }

        // Supprimer les anciens tokens pour cet utilisateur
        $passwordResetTokenRepository->deleteOldTokensForUser($user);

        // Générer un token unique
        do {
            $token = bin2hex(random_bytes(32));
            $existingToken = $passwordResetTokenRepository->findOneBy(['token' => $token]);
        } while ($existingToken); // Si un token existe déjà, on en génère un autre

        // Créer et stocker le nouveau token
        $passwordResetToken = new PasswordResetToken($user, $token);
        $passwordResetTokenRepository->save($passwordResetToken, true);

        // Récupérer l'URL du frontend via services.yaml
        $frontendUrl = $this->getParameter('frontend_url');
        $resetUrl = sprintf('%s/reset-password?token=%s', $frontendUrl, urlencode($token));

        $expiresAt = $passwordResetToken->getExpiresAt();
        $now = new \DateTime();
        $tokenExpiration = max(0, $now->diff($expiresAt)->i); // Nombre de minutes restantes

        // Envoyer l'email
        $emailMessage = (new TemplatedEmail())
            ->from(new Address('no-reply@spintobet.com', 'SpinToBet'))
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->htmlTemplate('emails/reset_password.html.twig')
            ->context([
                'resetUrl' => $resetUrl,
                'tokenExpiration' => $tokenExpiration,
            ]);

        $mailer->send($emailMessage);

        return new JsonResponse(['message' => 'Si un compte existe, un email de réinitialisation a été envoyé.'], 200);
    }

    #[Route('/api/reset-password', name: 'reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        PasswordResetTokenRepository $passwordResetTokenRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        // Décodage du corps de la requête
        $data = json_decode($request->getContent(), true);

        // Créer une instance de DTO et remplir avec les données reçues
        $dto = new UserPatchDTO();
        $dto->newPassword = $data['password'] ?? null;

        // Validation du DTO
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => $errors[0]->getMessage()], 400);
        }

        // Récupérer l'email et le token
        $email = $data['email'] ?? null;
        $token = $data['token'] ?? null;

        // Validation de l'email et du token
        if (!$token) {
            return new JsonResponse(['error' => 'Le token est requis.'], 400);
        }

        if (!$email || !$dto->newPassword) {
            return new JsonResponse(['error' => 'Il est nécessaire de fournir un email et un nouveau mot de passe.'], 400);
        }

        // Vérifier si l'utilisateur existe et est valide
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user || !$user->isVerified() !== null) {
            return new JsonResponse(['error' => 'Compte invalide ou non vérifié.'], 400);
        }

        // Vérifier si le token est valide
        $passwordResetToken = $passwordResetTokenRepository->findOneBy(['token' => $token, 'user' => $user]);
        if (!$passwordResetToken) {
            return new JsonResponse(['error' => 'Le token n\'est pas valide. Veuillez refaire une demande de réinitialisation.'], 400);
        }

        // Vérifier si le token est expiré
        if ($passwordResetToken->getExpiresAt() < new \DateTime()) {
            return new JsonResponse(['error' => 'Le token a expiré. Veuillez refaire une demande de réinitialisation.'], 400);
        }

        // Hasher le nouveau mot de passe et mettre à jour l'entité
        $hashedPassword = $passwordHasher->hashPassword($user, $dto->newPassword);
        $user->setPassword($hashedPassword);

        // Supprimer le token après usage
        $em->remove($passwordResetToken);
        $em->flush();

        return new JsonResponse(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
    }
}
