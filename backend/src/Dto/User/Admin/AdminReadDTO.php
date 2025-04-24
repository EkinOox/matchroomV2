<?php

namespace App\Dto\User\Admin;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

final class AdminReadDTO
{
    #[Groups(['read:admin'])]
    public ?Uuid $id = null;

    #[Groups(['read:admin'])]
    public ?string $email = null;

    #[Groups(['read:admin'])]
    public bool $isVerified = false;

    #[Groups(['read:admin'])]
    public ?string $pseudo = null;

    #[Groups(['read:admin'])]
    public ?float $balance = null;

    #[Groups(['read:admin'])]
    public ?string $referralCode = null;

    #[Groups(['read:admin'])]
    public ?array $roles = null;

    #[Groups(['read:admin'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['read:admin'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['read:admin'])]
    public ?\DateTimeInterface $deletedAt = null;

    #[Groups(['read:admin'])]
    public ?\DateTimeInterface $lastLaunch = null;
}
