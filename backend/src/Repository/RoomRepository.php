<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    // /**
    //  * Recherche des chambres en fonction des critères spécifiés et des hôtels
    //  * @param array $hotelsIds Liste des IDs des hôtels à inclure dans la recherche
    //  * @param int $NbVoyageur Nombre de voyageurs
    //  * @param array $critere Liste des IDs des critères de la recherche
    //  */
    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r')
    //         ->innerJoin('r.features', 'f')  // Jointure avec la table "Feature" via la relation ManyToMany
    //         ->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     // Ajouter le critère de recherche pour les features
    //     if (!empty($critere)) {
    //         $qb->andWhere('f.id IN (:critere)')
    //             ->setParameter('critere', $critere);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);

    //     // Trie les chambres par le nombre de critères correspondant
    //     $qb->addSelect('COUNT(f.id) AS HIDDEN criteriaCount')
    //         ->groupBy('r.id')
    //         ->orderBy('criteriaCount', 'DESC');  // Trier par le nombre de critères correspondants

    //     return $qb;
    // }

    /**
     * Recherche des chambres en fonction des critères spécifiés, des hôtels, et exclut celles déjà réservées
     * pendant la période donnée
     * 
     * @param array $hotelsIds Liste des IDs des hôtels à inclure dans la recherche
     * @param int $NbVoyageur Nombre de voyageurs
     * @param array $critere Liste des IDs des critères de la recherche
     * @param \DateTimeImmutable $dateDebut Date de début de la réservation
     * @param \DateTimeImmutable $dateFin Date de fin de la réservation
     */
    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere,
    //     \DateTimeImmutable $dateDebut,
    //     \DateTimeImmutable $dateFin
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r')
    //         ->innerJoin('r.features', 'f')  // Jointure avec la table "Feature" via la relation ManyToMany
    //         ->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     // Ajouter le critère de recherche pour les features
    //     if (!empty($critere)) {
    //         $qb->andWhere('f.id IN (:critere)')
    //             ->setParameter('critere', $critere);
    //     }

    //     // Exclure les chambres qui sont déjà réservées pour la période donnée
    //     $qb->leftJoin('r.reservations', 'res')
    //         ->andWhere(
    //             $qb->expr()->orX(
    //                 $qb->expr()->isNull('res.id'), // Pas de réservation existante
    //                 $qb->expr()->orX(
    //                     $qb->expr()->lt('res.endAt', ':dateDebut'), // La réservation se termine avant le début de la période
    //                     $qb->expr()->gt('res.startedAt', ':dateFin') // La réservation commence après la fin de la période
    //                 )
    //             )
    //         );

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur)
    //         ->setParameter('dateDebut', $dateDebut)
    //         ->setParameter('dateFin', $dateFin);

    //     // Trier les chambres par le nombre de critères correspondants
    //     $qb->addSelect('COUNT(f.id) AS HIDDEN criteriaCount')
    //         ->groupBy('r.id')
    //         ->orderBy('criteriaCount', 'DESC');  // Trier par le nombre de critères correspondants

    //     return $qb;
    // }


    // Fail
    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere,
    //     \DateTimeImmutable $dateDebut,
    //     \DateTimeImmutable $dateFin,
    //     Uuid $userId // Ajouter l'ID de l'utilisateur pour exclure les chambres avec des négociations en cours
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r')
    //         ->innerJoin('r.features', 'f')  // Jointure avec la table "Feature" via la relation ManyToMany
    //         ->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     // Ajouter le critère de recherche pour les features
    //     if (!empty($critere)) {
    //         $qb->andWhere('f.id IN (:critere)')
    //             ->setParameter('critere', $critere);
    //     }

    //     // Exclure les chambres qui sont déjà réservées pour la période donnée
    //     $qb->leftJoin('r.reservations', 'res')
    //         ->andWhere(
    //             $qb->expr()->orX(
    //                 $qb->expr()->isNull('res.id'), // Pas de réservation existante
    //                 $qb->expr()->orX(
    //                     $qb->expr()->lt('res.endAt', ':dateDebut'), // La réservation se termine avant le début de la période
    //                     $qb->expr()->gt('res.startedAt', ':dateFin') // La réservation commence après la fin de la période
    //                 )
    //             )
    //         );

    //     // Exclure les chambres où l'utilisateur a déjà une négociation en cours
    //     $qb->leftJoin('r.negociations', 'n')  // Jointure avec la table "Negociation"
    //         ->andWhere('n.user != :userId OR n.id IS NULL') // Exclure les chambres où l'utilisateur a déjà une négociation
    //         ->setParameter('userId', $userId);

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur)
    //         ->setParameter('dateDebut', $dateDebut)
    //         ->setParameter('dateFin', $dateFin);

    //     // Trier les chambres par le nombre de critères correspondants
    //     $qb->addSelect('COUNT(f.id) AS HIDDEN criteriaCount')
    //         ->groupBy('r.id')
    //         ->orderBy('criteriaCount', 'DESC');  // Trier par le nombre de critères correspondants

    //     return $qb;
    // }

    public function searchRooms(
        array $hotelsIds,
        int $NbVoyageur,
        array $critere,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin,
        array $negotiatedRoomIds = [] // Ajouter un paramètre pour exclure les chambres déjà négociées
    ): QueryBuilder {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.features', 'f')  // Jointure avec la table "Feature" via la relation ManyToMany
            ->andWhere('r.hotel IN (:hotels)')
            ->andWhere('r.capacity >= :NbVoyageur');

        // Ajouter le critère de recherche pour les features
        if (!empty($critere)) {
            $qb->andWhere('f.id IN (:critere)')
                ->setParameter('critere', $critere);
        }

        // Exclure les chambres qui sont déjà réservées pour la période donnée
        $qb->leftJoin('r.reservations', 'res')
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNull('res.id'), // Pas de réservation existante
                    $qb->expr()->orX(
                        $qb->expr()->lt('res.endAt', ':dateDebut'), // La réservation se termine avant le début de la période
                        $qb->expr()->gt('res.startedAt', ':dateFin') // La réservation commence après la fin de la période
                    )
                )
            );

        // Exclure les chambres où l'utilisateur a déjà une négociation en cours
        if (!empty($negotiatedRoomIds)) {
            $qb->andWhere('r.id NOT IN (:negotiatedRooms)')
                ->setParameter('negotiatedRooms', $negotiatedRoomIds); // Exclure les chambres déjà négociées
        }

        // Ajouter les paramètres à la requête
        $qb->setParameter('hotels', $hotelsIds)
            ->setParameter('NbVoyageur', $NbVoyageur)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);

        // Trier les chambres par le nombre de critères correspondants
        $qb->addSelect('COUNT(f.id) AS HIDDEN criteriaCount')
            ->groupBy('r.id')
            ->orderBy('criteriaCount', 'DESC');  // Trier par le nombre de critères correspondants

        return $qb;
    }
}
