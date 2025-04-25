<?php

namespace App\State\RoomNegociation;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Negociation\NegociationOutput;
use App\Dto\Room\RoomOutput;
use App\Repository\NegociationRepository;
use Symfony\Bundle\SecurityBundle\Security;

class NegociationCollectionProvider implements ProviderInterface
{
    public function __construct(
        private NegociationRepository $repository,
        private Security $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $user = $this->security->getUser();
        $negociations = $this->repository->findBy(['user' => $user]);

        return array_map(function ($negociation) {
            $dto = new NegociationOutput();
            $dto->id = $negociation->getId();
            $dto->proposedPrice = $negociation->getProposedPrice();
            $dto->counterOffer = $negociation->getCounterOffer();
            $dto->status = $negociation->getStatus();
            $dto->startDate = $negociation->getStartDate();
            $dto->endDate = $negociation->getEndDate();
            $dto->createdAt = $negociation->getCreatedAt();
            $room = $negociation->getRoom();
            $roomDto = new RoomOutput();
            $roomDto->id = $room->getId();
            $roomDto->name = $room->getName();
            $roomDto->description = $room->getDescription();
            $roomDto->price = $room->getPrice();
            $roomDto->folderImage = $room->getFolderImage();
            $roomDto->capacity = $room->getCapacity();

            $dto->room = $roomDto;

            return $dto;
        }, $negociations);
    }
}
