<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\PasswordResetToken;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PasswordResetToken>
 */
class PasswordResetTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordResetToken::class);
    }

    public function save(PasswordResetToken $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime un token spécifique et force la mise à jour de la base de données.
     */
    public function remove(PasswordResetToken $passwordResetToken, bool $flush = true): void
    {
        $this->getEntityManager()->remove($passwordResetToken);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime tous les tokens existants pour un utilisateur donné.
     */
    public function deleteOldTokensForUser(User $user): void
    {
        $tokens = $this->findBy(['user' => $user]);

        foreach ($tokens as $token) {
            $this->remove($token, false); // Supprime sans flusher à chaque itération
        }

        $this->getEntityManager()->flush(); // Flush une seule fois après toutes les suppressions
    }

    // /**
    //  * Supprime tous les tokens existants pour un utilisateur donné.
    //  */
    // public function deleteOldTokensForUser(User $user): void
    // {
    //     $this->createQueryBuilder('t')
    //         ->delete()
    //         ->where('t.user = :user')
    //         ->setParameter('user', $user)
    //         ->getQuery()
    //         ->execute();
    // }
}
