<?php

namespace App\Dto\Negociation;

use App\Dto\Room\RoomOutput;
use Symfony\Component\Serializer\Annotation\Groups;

class NegociationOutput
{
    #[Groups(['negociation:read'])]
    public int $id;

    #[Groups(['negociation:read'])]
    public float $proposedPrice;

    #[Groups(['negociation:read'])]
    public ?float $counterOffer = null;

    #[Groups(['negociation:read'])]
    public string $status;

    #[Groups(['negociation:read'])]
    public \DateTimeImmutable $createdAt;

    #[Groups(['negociation:read'])]
    public RoomOutput $room;
}
