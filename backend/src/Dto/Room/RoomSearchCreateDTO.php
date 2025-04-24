<?php

namespace App\Dto\Room;

use Symfony\Component\Serializer\Annotation\Groups;

final class RoomSearchCreateDTO
{
    #[Groups(['create:room_search'])]
    public ?float $longitude = null;

    #[Groups(['create:room_search'])]
    public ?float $latitude = null;

    #[Groups(['create:room_search'])]
    public ?int $NbVoyageur = null;

    #[Groups(['create:room_search'])]
    public array $critere = [];
}
