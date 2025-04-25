<?php

namespace App\Dto\Room;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\Hotel\HotelReadDTO;

final class RoomSearchReadDTO
{
    #[Groups(['readSearch:room'])]
    public ?int $id = null;

    #[Groups(['readSearch:room'])]
    public ?string $name = null;

    #[Groups(['readSearch:room'])]
    public ?string $description = null;

    #[Groups(['readSearch:room'])]
    public ?float $price = null;

    #[Groups(['readSearch:room'])]
    public ?string $folderImage = null;

    #[Groups(['readSearch:room'])]
    public ?int $capacity = null;

    #[Groups(['readSearch:room'])]
    public ?float $longitudeClient = null;

    #[Groups(['readSearch:room'])]
    public ?float $latitudeClient = null;

    /**
     * @var FeatureReadDTO[]
     */
    #[Groups(['readSearch:room'])]
    public array $features = [];

    /**
     * @var HotelReadDTO
     */
    #[Groups(['readSearch:room'])]
    public ?HotelReadDTO $hotel = null;
}
