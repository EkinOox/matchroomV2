<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


final class UserPatchProcessor implements ProcessorInterface
{
    public function __construct(
        private UserRepository $userRepository,
        #[Autowire(service: PersistProcessor::class)] private ProcessorInterface $persistProcessor,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    /**
     * Traite la mise à jour d'une entité utilisateur.
     *
     * Cette méthode gère la logique de mise à jour du pseudo et/ou du mot de passe d'un utilisateur.
     * Elle valide le mot de passe actuel si un nouveau mot de passe est fourni et met à jour
     * l'entité utilisateur en conséquence.
     *
     * @param mixed $data Les données de l'objet de transfert de données (DTO) contenant les informations de mise à jour.
     * @param Operation $operation L'opération API en cours d'exécution.
     * @param array $uriVariables Les variables URI pour l'opération.
     * @param array $context Le contexte de l'opération, incluant les données précédentes.
     * @return JsonResponse Une réponse JSON indiquant le succès de la mise à jour.
     * @throws BadRequestHttpException Si le mot de passe actuel est manquant ou invalide.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        /** @var UserPatchDTO|AdminPatchDTO $data */

        // Récupérer l'utilisateur depuis la base de données
        $user = $this->userRepository->findOneBy(['id' => $uriVariables['id'], 'deletedAt' => null]);

        // Vérification si l'utilisateur existe et n'est pas bloqué
        if (!$user) {
            return new JsonResponse(['message' => 'Cet utilisateur n\'existe pas ou est bloqué.'], JsonResponse::HTTP_FORBIDDEN);
        }

        // Si l'admin met à jour, on applique des règles supplémentaires
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            // Admin peut mettre à jour les rôles, le solde, etc.
            if (isset($data->roles)) {
                $user->setRoles($data->roles);
            }

            if (isset($data->balance)) {
                $user->setBalance($data->balance);
            }

            if (isset($data->email)) {
                $user->setEmail($data->email);
            }

            if (isset($data->password)) {
                $user->setPassword(
                    $this->passwordHasher->hashPassword($user, $data->password)
                );
            }
        }

        // Vérification de l'unicité du pseudo
        if ($data->pseudo !== null) {
            $user->setPseudo($data->pseudo);
        }

        // Vérifier et mettre à jour le mot de passe
        if (isset($data->newPassword) && $data->newPassword !== null) {
            if (empty($data->currentPassword)) {
                throw new BadRequestHttpException('Le mot de passe actuel est requis pour changer le mot de passe.');
            }

            if (!$this->passwordHasher->isPasswordValid($user, $data->currentPassword)) {
                throw new BadRequestHttpException('Le mot de passe actuel est incorrect.');
            }

            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $data->newPassword)
            );
        }

        // Marquer l'entité comme modifiée et flush
        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return new JsonResponse(['message' => 'Utilisateur mis à jour avec succès.'], JsonResponse::HTTP_OK);
    }
}
