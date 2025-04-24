<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Feature;

class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    // /**
    //  * Recherche des chambres en fonction des critères spécifiés et des hôtels
    //  * @param array $hotelsIds Liste des IDs des hôtels à inclure dans la recherche
    //  */
    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     foreach ($critere as $criterium) {
    //         $qb->andWhere('r.features LIKE :criterium');
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur)
    //         ->setParameter('criterium', '%' . $criterium . '%');

    //     return $qb;
    // }


    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     foreach ($critere as $criterium) {
    //         $qb->andWhere(':criterium MEMBER OF r.features');
    //         $qb->setParameter('criterium', $criterium);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);

    //     return $qb;
    // }

    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     foreach ($critere as $index => $criterium) {
    //         $qb->andWhere(':criterium' . $index . ' MEMBER OF r.features');
    //         $qb->setParameter('criterium' . $index, $criterium);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);

    //     return $qb;
    // }

    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     foreach ($critere as $index => $criterium) {
    //         $qb->andWhere($qb->expr()->exists(
    //             $this->createQueryBuilder('rf')
    //                 ->select('1')
    //                 ->from('App:RoomFeature', 'rf')
    //                 ->where('rf.room = r.id')
    //                 ->andWhere('rf.feature = :feature_id_' . $index)
    //                 ->getDQL()
    //         ))->setParameter('feature_id_' . $index, $criterium);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);

    //     return $qb;
    // }

    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {

    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     // Ajouter des critères supplémentaires (ex : les caractéristiques)
    //     foreach ($critere as $index => $criterium) {
    //         // Ici, on cherche par ID de caractéristique, pas par nom
    //         $qb->andWhere(':feature_id_' . $index . ' MEMBER OF r.features');
    //         $qb->setParameter('feature_id_' . $index, $criterium);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);
    //     dd($qb->getQuery()->getSQL());
    //     return $qb;
    // }


    // public function searchRooms(
    //     array $hotelsIds,
    //     int $NbVoyageur,
    //     array $critere = []
    // ): QueryBuilder {
    //     $qb = $this->createQueryBuilder('r');

    //     // Construire la requête avec les critères
    //     $qb->andWhere('r.hotel IN (:hotels)')
    //         ->andWhere('r.capacity >= :NbVoyageur');

    //     // Récupérer les IDs des caractéristiques à partir de leur nom
    //     $featureIds = [];
    //     if (!empty($critere)) {
    //         $featureNames = $critere; // Les noms des caractéristiques à rechercher

    //         // Récupérer les IDs des caractéristiques à partir de leur nom
    //         $features = $this->getEntityManager()
    //             ->getRepository(Feature::class)
    //             ->findBy(['name' => $featureNames]);

    //         // Extraire les IDs
    //         foreach ($features as $feature) {
    //             $featureIds[] = $feature->getId();
    //         }
    //     }

    //     // Ajouter des critères supplémentaires (ex : les caractéristiques)
    //     foreach ($featureIds as $index => $featureId) {
    //         // Ici, on cherche par ID de caractéristique, pas par nom
    //         $qb->andWhere(':feature_id_' . $index . ' MEMBER OF r.features');
    //         $qb->setParameter('feature_id_' . $index, $featureId);
    //     }

    //     // Ajouter les paramètres à la requête
    //     $qb->setParameter('hotels', $hotelsIds)
    //         ->setParameter('NbVoyageur', $NbVoyageur);

    //     return $qb;
    // }



    /**
     * Recherche des chambres en fonction des critères spécifiés et des hôtels
     * @param array $hotelsIds Liste des IDs des hôtels à inclure dans la recherche
     * @param int $NbVoyageur Nombre de voyageurs
     */
    public function searchRooms(
        array $hotelsIds,
        int $NbVoyageur
    ): QueryBuilder {
        $qb = $this->createQueryBuilder('r');

        // Construire la requête avec les critères
        $qb->andWhere('r.hotel IN (:hotels)')
            ->andWhere('r.capacity >= :NbVoyageur');

        // Ajouter les paramètres à la requête
        $qb->setParameter('hotels', $hotelsIds)
            ->setParameter('NbVoyageur', $NbVoyageur);

        return $qb;
    }
}
