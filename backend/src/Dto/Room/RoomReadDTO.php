<?php

namespace App\Dto\Room;

use App\Dto\Feature\FeatureReadDTO;
use Symfony\Component\Serializer\Annotation\Groups;

final class RoomReadDTO
{
    #[Groups(['read:room'])]
    public ?int $id = null;

    #[Groups(['read:room'])]
    public ?string $name = null;

    #[Groups(['read:room'])]
    public ?string $description = null;

    #[Groups(['read:room'])]
    public ?float $price = null;

    #[Groups(['read:room'])]
    public ?string $folderImage = null;

    #[Groups(['read:room'])]
    public ?int $capacity = null;

    #[Groups(['read:room'])]
    public ?int $acceptanceThreshold = null;

    #[Groups(['read:room'])]
    public ?int $refusalThreshold = null;

    #[Groups(['read:room'])]
    public ?\DateTimeImmutable $createdAt = null;

    /**
     * @var FeatureReadDTO[]
     */
    #[Groups(['read:room'])]
    public array $features = [];

    /**
     *
     * @var HotelReadDTO
     */
    #[Groups(['read:room'])]
    public ?int $hotelId = null;

    // Vous pouvez ajouter d'autres propriétés si nécessaire
}
