<?php

namespace App\Dto\Hotel;

use Symfony\Component\Serializer\Annotation\Groups;

final class HotelReadDTO
{
    #[Groups(['read:hotel', 'read:user', 'read:room', 'readSearch:room'])]
    public ?int $id = null;

    #[Groups(['read:hotel', 'read:user', 'readSearch:room'])]
    public ?string $name = null;

    #[Groups(['read:hotel'])]
    public ?\DateTimeImmutable $createdAt = null;

    #[Groups(['read:hotel', 'readSearch:room'])]
    public ?string $adress = null;

    #[Groups(['read:hotel', 'readSearch:room'])]
    public ?float $latitude = null;

    #[Groups(['read:hotel', 'readSearch:room'])]
    public ?float $longitude = null;
}
