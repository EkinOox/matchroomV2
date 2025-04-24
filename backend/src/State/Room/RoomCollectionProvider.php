<?php

namespace App\State\Room;

use App\Entity\Room;
use App\Dto\Room\RoomReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class RoomCollectionProvider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider,
        private TokenStorageInterface $tokenStorage
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        // Récupérer l'utilisateur connecté
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            throw new \LogicException('The security token should be available.');
        }

        /** @var User $user */
        $user = $token->getUser();
        if (null === $user) {
            throw new \LogicException('Utilisateur invalide.');
        }

        $hotel = $user->getHotel();
        if (null === $hotel) {
            throw new \LogicException('L\'utilisateur n\'est associé à aucun hôtel.');
        }

        // Ajouter un filtre pour l'hôtel
        $context['filters']['hotel.id'] = $hotel->getId();

        $collection = $this->collectionProvider->provide($operation, $uriVariables, $context);

        // Si c'est une collection paginée
        if ($collection instanceof PaginatorInterface) {
            $dtos = [];
            foreach ($collection as $room) {
                $dtos[] = $this->mapToDto($room);
            }

            return new TraversablePaginator(
                new \ArrayIterator($dtos),
                $collection->getCurrentPage(),
                $collection->getItemsPerPage(),
                $collection->getTotalItems()
            );
        }

        // Pour les collections non paginées
        return array_map([$this, 'mapToDto'], iterator_to_array($collection));
    }

    private function mapToDto(Room $room): RoomReadDTO
    {
        $dto = new RoomReadDTO();
        $dto->id = $room->getId();
        $dto->name = $room->getName();
        $dto->hotelId = $room->getHotel()->getId();
        $dto->description = $room->getDescription();
        $dto->price = $room->getPrice();
        $dto->folderImage = $room->getFolderImage();
        $dto->capacity = $room->getCapacity();
        $dto->acceptanceThreshold = $room->getAcceptanceThreshold();
        $dto->refusalThreshold = $room->getRefusalThreshold();
        $dto->createdAt = $room->getCreatedAt();

        // Mapper les caractéristiques
        foreach ($room->getFeatures() as $feature) {
            $featureDto = new \App\Dto\Feature\FeatureReadDTO();
            $featureDto->id = $feature->getId();
            $featureDto->name = $feature->getName();
            $dto->features[] = $featureDto;
        }

        return $dto;
    }
}
