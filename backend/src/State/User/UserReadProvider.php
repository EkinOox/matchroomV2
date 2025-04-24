<?php

namespace App\State\User;

use App\Entity\User;
use App\Dto\User\UserReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;

final class UserReadProvider implements ProviderInterface
{
    public function __construct(
        private ItemProvider $itemProvider,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?UserReadDTO
    {
        /** @var User|null $user */
        $user = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$user) {
            return null;
        }

        $dto = new UserReadDTO();
        $dto->id = $user->getId();
        $dto->email = $user->getEmail();
        $dto->firstname = $user->getFirstname();
        $dto->lastname = $user->getLastname();
        $dto->roles = $user->getRoles();
        $dto->createdAt = $user->getCreatedAt();
        $dto->updatedAt = $user->getUpdatedAt();

        // Si l'utilisateur est associé à un hôtel, mapper les informations de l'hôtel
        if ($user->getHotel()) {
            $dto->hotel = new \App\Dto\Hotel\HotelReadDTO();
            $dto->hotel->id = $user->getHotel()->getId();
            $dto->hotel->name = $user->getHotel()->getName();
        }

        return $dto;
    }
}
