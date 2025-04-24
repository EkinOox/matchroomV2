<?php

namespace App\State\User;

use App\Entity\User;
use App\Dto\User\Admin\AdminReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;

final class AdminCollectionProvider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $collection = $this->collectionProvider->provide($operation, $uriVariables, $context);

        // Si c'est une collection paginée
        if ($collection instanceof PaginatorInterface) {
            $dtos = [];
            foreach ($collection as $user) {
                $dtos[] = $this->mapToDto($user);
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

    private function mapToDto(User $user): AdminReadDTO
    {
        $dto = new AdminReadDTO();
        $dto->id = $user->getId();
        $dto->email = $user->getEmail();
        $dto->isVerified = $user->isVerified();
        $dto->pseudo = $user->getPseudo();
        $dto->balance = $user->getBalance();
        $dto->referralCode = $user->getReferralCode();
        $dto->roles = $user->getRoles();
        $dto->createdAt = $user->getCreatedAt();
        $dto->updatedAt = $user->getUpdatedAt();
        $dto->deletedAt = $user->getDeletedAt();
        $dto->lastLaunch = $user->getLastLaunch();

        return $dto;
    }
}
