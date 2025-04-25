<?php

namespace App\State\User;

use App\Entity\User;
use App\Dto\User\UserReadDTO;
use App\Dto\Badge\BadgeReadDTO;
use App\Dto\Hotel\HotelReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UserReadProvider implements ProviderInterface
{
    public function __construct(
        private ItemProvider $itemProvider,
        private TokenStorageInterface $tokenStorage
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?UserReadDTO
    {
        // Récupérer l'utilisateur actuellement connecté à partir du TokenStorageInterface
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new \LogicException('The security token should be available.');
        }

        /** @var User $user */
        $user = $token->getUser();
        if (null === $user) {
            throw new \LogicException('Utilisateur invalide.');
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
            $dto->hotel = new HotelReadDTO();
            $dto->hotel->id = $user->getHotel()->getId();
            $dto->hotel->name = $user->getHotel()->getName();
        }

        // Ajouter les badges de l'utilisateur
        foreach ($user->getBadges() as $badge) {
            $badgeDto = new BadgeReadDTO();
            $badgeDto->id = $badge->getId();
            $badgeDto->name = $badge->getName();
            $badgeDto->description = $badge->getDescription();
            $badgeDto->pathImage = $badge->getPathImage();
            $badgeDto->level = $badge->getLevel();

            // Ajouter le badge à l'array $badges du DTO
            $dto->badges[] = $badgeDto;
        }

        return $dto;
    }
}
