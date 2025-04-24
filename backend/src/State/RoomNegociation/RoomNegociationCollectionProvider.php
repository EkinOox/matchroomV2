<?php

namespace App\State\RoomNegociation;

use App\Entity\Negociation;
use ApiPlatform\Metadata\Operation;
use App\Dto\Feature\FeatureReadDTO;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Room\RoomNegociationReadDTO;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\State\Pagination\TraversablePaginator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class RoomNegociationCollectionProvider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider,
        private TokenStorageInterface $tokenStorage,
        private ManagerRegistry $managerRegistry
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

        // Ajouter un filtre pour l'hôtel et le statut
        $context['filters']['room.hotel.id'] = $hotel->getId();
        $context['filters']['status'] = 'pending';

        $collection = $this->collectionProvider->provide($operation, $uriVariables, $context);

        // Si c'est une collection paginée
        if ($collection instanceof PaginatorInterface) {
            $dtos = [];
            foreach ($collection as $negociation) {
                $dtos[] = $this->mapToDto($negociation);
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

    private function mapToDto(Negociation $negociation): RoomNegociationReadDTO
    {
        $dto = new RoomNegociationReadDTO();
        $dto->id = $negociation->getRoom()->getId();
        $dto->name = $negociation->getRoom()->getName();
        $dto->description = $negociation->getRoom()->getDescription();
        $dto->price = $negociation->getRoom()->getPrice();
        $dto->folderImage = $negociation->getRoom()->getFolderImage();
        $dto->capacity = $negociation->getRoom()->getCapacity();
        $dto->acceptanceThreshold = $negociation->getRoom()->getAcceptanceThreshold();
        $dto->refusalThreshold = $negociation->getRoom()->getRefusalThreshold();
        $dto->createdAt = $negociation->getRoom()->getCreatedAt();

        // Mapper les caractéristiques
        foreach ($negociation->getRoom()->getFeatures() as $feature) {
            $featureDto = new FeatureReadDTO();
            $featureDto->id = $feature->getId();
            $featureDto->name = $feature->getName();
            $dto->features[] = $featureDto;
        }

        // Mapper les informations de négociation
        $dto->proposedPrice = $negociation->getProposedPrice();
        $dto->responseTime = $negociation->getResponseTime();
        $dto->status = $negociation->getStatus();
        $dto->counterOffer = $negociation->getCounterOffer();
        $dto->createdAt = $negociation->getCreatedAt();

        return $dto;
    }
}
