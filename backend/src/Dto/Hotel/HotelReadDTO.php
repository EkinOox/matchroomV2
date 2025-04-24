<?php

namespace App\Dto\Hotel;

use Symfony\Component\Serializer\Annotation\Groups;

final class HotelReadDTO
{
    #[Groups(['read:hotel', 'read:user', 'read:room'])]
    public ?int $id = null;

    #[Groups(['read:hotel', 'read:user'])]
    public ?string $name = null;

    #[Groups(['read:hotel'])]
    public ?\DateTimeImmutable $createdAt = null;

    #[Groups(['read:hotel'])]
    public ?string $adress = null;

    #[Groups(['read:hotel'])]
    public ?float $latitude = null;

    #[Groups(['read:hotel'])]
    public ?float $longitude = null;
}
