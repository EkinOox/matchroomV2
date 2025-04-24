<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Security\Exception\TooManyRequestsException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiAuthenticator extends AbstractAuthenticator
{
    private $entityManager;
    private $rateLimiterFactory;

    public function __construct(EntityManagerInterface $entityManager, RateLimiterFactory $rateLimiterFactory)
    {
        $this->entityManager = $entityManager;
        $this->rateLimiterFactory = $rateLimiterFactory;
    }

    public function supports(Request $request): ?bool
    {
        return $request->getMethod() === 'POST' && $request->getPathInfo() === '/api/login';
    }

    public function authenticate(Request $request): Passport
    {
        // Si la requête est un POST sur /api/login, on récupère les identifiants email et mot de passe.
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!isset($email) || !isset($password)) {
            throw new AuthenticationException('L\'email et le mot de passe sont requis.');
        }

        // Associe l'email et l'adresse IP du client pour le rate limiter
        // $clientIp = $request->getClientIp();
        // $limiterKey = $email . '_' . $clientIp;

        // // Appliquer le rate limiter
        // $limiter = $this->rateLimiterFactory->create($limiterKey);
        // $limit = $limiter->consume();

        // if (!$limit->isAccepted()) {
        //     throw new TooManyRequestsException($limit->getRetryAfter()->getTimestamp(), 'Trop de tentatives de connexion. Veuillez réessayer dans :');
        // }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            throw new AuthenticationException('Les identifiants sont incorrects.');
        }

        // Vérification du mot de passe
        if (!password_verify($password, $user->getPassword())) {
            throw new AuthenticationException('Les identifiants sont incorrects.');
        }

        // Retourne un Passport pour un utilisateur valide
        return new SelfValidatingPassport(
            new UserBadge($user->getEmail())
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($exception instanceof TooManyRequestsException) {
            return new JsonResponse([
                'message' => $exception->getMessageKey()
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return new JsonResponse([
            'message' => $exception->getMessage()
        ], Response::HTTP_UNAUTHORIZED);
    }

    //    public function start(Request $request, AuthenticationException $authException = null): Response
    //    {
    //        /*
    //         * If you would like this class to control what happens when an anonymous user accesses a
    //         * protected page (e.g. redirect to /login), uncomment this method and make this class
    //         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
    //         *
    //         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //         */
    //    }
}
