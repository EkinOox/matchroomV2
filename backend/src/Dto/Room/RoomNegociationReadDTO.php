<?php

namespace App\Dto\Room;

use Symfony\Component\Serializer\Annotation\Groups;

final class RoomNegociationReadDTO
{
    #[Groups(['read:room_negotiation'])]
    public ?int $idNegociation = null;

    #[Groups(['read:room_negotiation'])]
    public ?int $idRoom = null;

    #[Groups(['read:room_negotiation'])]
    public ?string $name = null;

    #[Groups(['read:room_negotiation'])]
    public ?string $description = null;

    #[Groups(['read:room_negotiation'])]
    public ?float $price = null;

    #[Groups(['read:room_negotiation'])]
    public ?string $folderImage = null;

    #[Groups(['read:room_negotiation'])]
    public ?int $capacity = null;

    #[Groups(['read:room_negotiation'])]
    public ?int $acceptanceThreshold = null;

    #[Groups(['read:room_negotiation'])]
    public ?int $refusalThreshold = null;

    #[Groups(['read:room_negotiation'])]
    public ?\DateTimeImmutable $createdAt = null;

    /**
     * @var FeatureReadDTO[]
     */
    #[Groups(['read:room_negotiation'])]
    public array $features = [];

    #[Groups(['read:room_negotiation'])]
    public ?float $proposedPrice = null;

    #[Groups(['read:room_negotiation'])]
    public ?\DateTimeImmutable $responseTime = null;

    #[Groups(['read:room_negotiation'])]
    public ?string $status = null;

    #[Groups(['read:room_negotiation'])]
    public ?float $counterOffer = null;
}
