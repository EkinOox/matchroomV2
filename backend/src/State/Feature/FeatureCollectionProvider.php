<?php

namespace App\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use App\Dto\Feature\FeatureReadDTO;
use App\Entity\Feature;

final class FeatureCollectionProvider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $collection = $this->collectionProvider->provide($operation, $uriVariables, $context);

        // Si c'est une collection paginée
        if ($collection instanceof PaginatorInterface) {
            $dtos = [];
            foreach ($collection as $feature) {
                $dtos[] = $this->mapToDto($feature);
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

    private function mapToDto(Feature $feature): FeatureReadDTO
    {
        $dto = new FeatureReadDTO();
        $dto->id = $feature->getId();
        $dto->name = $feature->getName();

        return $dto;
    }
}
