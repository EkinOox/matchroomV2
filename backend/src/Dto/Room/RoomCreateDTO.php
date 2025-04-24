<?php

namespace App\Dto\Room;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class RoomCreateDTO
{
    #[Groups(['create:room'])]
    #[Assert\NotBlank]
    public ?string $name = null;

    #[Groups(['create:room'])]
    #[Assert\NotBlank]
    public ?string $description = null;

    #[Groups(['create:room'])]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public ?float $price = null;

    #[Groups(['create:room'])]
    #[Assert\NotBlank]
    public ?string $folderImage = null;

    #[Groups(['create:room'])]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public ?int $capacity = null;

    #[Groups(['create:room'])]
    #[Assert\Positive]
    public ?int $acceptanceThreshold = null;

    #[Groups(['create:room'])]
    #[Assert\Positive]
    public ?int $refusalThreshold = null;

    #[Groups(['create:room'])]
    public ?array $features = [];
}
