<?php

namespace App\Dto\User;

use App\Dto\Hotel\HotelReadDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

final class UserReadDTO
{
    #[Groups(['read:user'])]
    public ?Uuid $id = null;

    #[Groups(['read:user'])]
    public ?string $email = null;

    #[Groups(['read:user'])]
    public ?string $firstname = null;

    #[Groups(['read:user'])]
    public ?string $lastname = null;

    #[Groups(['read:user'])]
    /**
     * @var list<string>
     */
    public array $roles = [];

    #[Groups(['read:user'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['read:user'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['read:user'])]
    public ?HotelReadDTO $hotel = null;

    #[Groups(['read:user'])]
    public array $badges = [];
}
