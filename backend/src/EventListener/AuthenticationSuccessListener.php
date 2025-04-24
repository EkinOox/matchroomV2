<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthenticationSuccessListener
{
    private $entityManager;
    private $refreshTokenRepository;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->refreshTokenRepository = $entityManager->getRepository(RefreshToken::class);
        $this->requestStack = $requestStack;
    }

    /**
     * Méthode appelée lorsqu'un utilisateur se connecte avec succès.
     */
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        // Récupérer l'utilisateur authentifié
        $user = $event->getAuthenticationToken()->getUser();

        // Vérifier si l'utilisateur existe et est valide
        if ($user instanceof User) {

            // Vérifier si la requête provient de /api/login
            $request = $this->requestStack->getCurrentRequest();
            if ($request && $request->getPathInfo() === '/api/login') {
                // Chercher et supprimer l'ancien refresh token de cet utilisateur
                $oldToken = $this->refreshTokenRepository->findOneBy(['username' => $user->getEmail()]);

                if ($oldToken) {
                    // Supprimer l'ancien refresh token
                    $this->entityManager->remove($oldToken);
                    $this->entityManager->flush();
                }
            }
        }
    }
}
