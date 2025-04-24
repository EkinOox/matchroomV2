<?php

namespace App\State\RoomSearch;

use App\Repository\RoomRepository;
use App\Dto\Hotel\HotelReadDTO;
use App\Dto\Feature\FeatureReadDTO;
use App\Repository\HotelRepository;
use App\Entity\Room;
use App\Dto\Room\RoomSearchReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<RoomSearchCreateDTO, RoomSearchReadDTO>
 */
final class RoomSearchProcessor implements ProcessorInterface
{
    public function __construct(
        private RoomRepository $roomRepository,
        private HotelRepository $hotelRepository
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RoomSearchReadDTO|TraversablePaginator
    {
        /** @var RoomSearchCreateDTO $data */
        // Récupérer les paramètres de recherche
        $longitude = $data->longitude;
        $latitude = $data->latitude;
        $NbVoyageur = $data->NbVoyageur;

        // Vérifier que les coordonnées sont fournies
        if (!$longitude || !$latitude) {
            throw new NotFoundHttpException('Les coordonnées de longitude et latitude sont requises.');
        }

        // Récupérer les hôtels à proximité (calcul de distance)
        $hotelsInRadius = $this->getNearbyHotels($longitude, $latitude);

        // Obtenir la requête personnalisée via le repository
        $queryBuilder = $this->roomRepository->searchRooms(
            $hotelsInRadius,
            $NbVoyageur
        );

        $query = $queryBuilder->getQuery();
        $collection = $query->getResult();

        // Si c'est une collection paginée
        if ($collection instanceof PaginatorInterface) {
            $dtos = [];
            foreach ($collection as $room) {
                $dtos[] = $this->mapToRoomSearchReadDto($room);
            }

            return new TraversablePaginator(
                new \ArrayIterator($dtos),
                $collection->getCurrentPage(),
                $collection->getItemsPerPage(),
                $collection->getTotalItems()
            );
        } else {
            // Pour les collections non paginées
            $dtos = array_map([$this, 'mapToRoomSearchReadDto'], iterator_to_array($collection));
            return new TraversablePaginator(
                new \ArrayIterator($dtos),
                1, // Current page
                count($dtos), // Items per page
                count($dtos) // Total items
            );
        }
    }

    /**
     * Calcule la distance en kilomètres entre deux points géographiques
     */
    private function getNearbyHotels(float $longitude, float $latitude): array
    {
        $hotels = $this->hotelRepository->findAll();
        $hotelsInRadius = [];
        foreach ($hotels as $hotel) {
            $distance = $this->calculateDistance($longitude, $latitude, $hotel->getLongitude(), $hotel->getLatitude());
            if ($distance <= 5) { // 5 kilomètres
                $hotelsInRadius[] = $hotel->getId();
            }
        }

        return $hotelsInRadius;
    }

    /**
     * Calcule la distance entre deux points géographiques
     */
    private function calculateDistance(float $longitude1, float $latitude1, float $longitude2, float $latitude2): float
    {
        $earthRadius = 6371; // Rayon moyen de la Terre en kilomètres

        // Convertir les degrés en radians
        $latFrom = deg2rad($latitude1);
        $lonFrom = deg2rad($longitude1);
        $latTo = deg2rad($latitude2);
        $lonTo = deg2rad($longitude2);

        // Calculer les différences
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Calculer la distance
        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function mapToRoomSearchReadDto(Room $room): RoomSearchReadDTO
    {
        $dto = new RoomSearchReadDTO();
        $dto->id = $room->getId();
        $dto->name = $room->getName();
        $dto->description = $room->getDescription();
        $dto->price = $room->getPrice();
        $dto->folderImage = $room->getFolderImage();
        $dto->capacity = $room->getCapacity();

        // Mapper les caractéristiques
        foreach ($room->getFeatures() as $feature) {
            $featureDto = new FeatureReadDTO();
            $featureDto->id = $feature->getId();
            $featureDto->name = $feature->getName();
            $dto->features[] = $featureDto;
        }

        // Mapper les informations de l'hôtel
        $hotel = $room->getHotel();
        $hotelDto = new HotelReadDTO();
        $hotelDto->id = $hotel->getId();
        $hotelDto->name = $hotel->getName();
        $hotelDto->createdAt = $hotel->getCreatedAt();
        $hotelDto->adress = $hotel->getAdress();
        $hotelDto->latitude = $hotel->getLatitude();
        $hotelDto->longitude = $hotel->getLongitude();
        $dto->hotel = $hotelDto;

        return $dto;
    }
}
