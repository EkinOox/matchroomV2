<?php

namespace App\Dto\Negociation;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class NegociationInput
{
    #[Assert\NotNull]
    #[Groups(['negociation:write'])]
    public ?string $room = null;

    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups(['negociation:write'])]
    public ?float $proposedPrice = null;

    #[Assert\Type(\DateTimeInterface::class)]
    #[Groups(['negociation:write'])]
    public ?\DateTimeInterface $startDate = null;

    #[Assert\Type(\DateTimeInterface::class)]
    #[Groups(['negociation:write'])]
    public ?\DateTimeInterface $endDate = null;
}

