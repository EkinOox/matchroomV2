<?php

namespace App\Dto\Negociation;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class NegociationInput
{
    #[Assert\NotNull]
    #[Groups(['negociation:write'])]
    public ?string $room = null; // IRI du Room (ex: /api/rooms/1)

    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups(['negociation:write'])]
    public ?float $proposedPrice = null;
}
