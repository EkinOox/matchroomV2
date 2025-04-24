<?php

namespace App\EventListener;

use App\Entity\User;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;

#[AsEntityListener(event: Events::postUpdate, entity: User::class, method: 'postUpdate')]
class SoftDeleteListener
{
    private $refreshTokenRepository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->refreshTokenRepository = $entityManager->getRepository(RefreshToken::class);
    }

    public function postUpdate(User $user): void
    {
        // Vérifie si l'utilisateur a été supprimé logiquement
        if ($user !== null) {
            // Supprime les tokens associés
            $this->removeRefreshTokens($user);
        }
    }

    private function removeRefreshTokens(User $user): void
    {
        $refreshTokens = $this->refreshTokenRepository->findBy(['username' => $user->getEmail()]);

        foreach ($refreshTokens as $token) {
            $this->entityManager->remove($token);
        }

        // Exécute les suppressions
        $this->entityManager->flush();
    }
}
