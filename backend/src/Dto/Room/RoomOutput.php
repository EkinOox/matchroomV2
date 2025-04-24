<?php

namespace App\Dto\Room;

use Symfony\Component\Serializer\Annotation\Groups;

class RoomOutput
{
    #[Groups(['negociation:read'])]
    public int $id;

    #[Groups(['negociation:read'])]
    public string $name;

    #[Groups(['negociation:read'])]
    public string $description;

    #[Groups(['negociation:read'])]
    public float $price;

    #[Groups(['negociation:read'])]
    public string $folderImage;

    #[Groups(['negociation:read'])]
    public int $capacity;
}
