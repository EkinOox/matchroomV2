<?php

namespace App\Dto\Badge;

use Symfony\Component\Serializer\Annotation\Groups;

final class BadgeReadDTO
{
    #[Groups(['read:user'])]
    public ?int $id = null;

    #[Groups(['read:user'])]
    public ?string $name = null;

    #[Groups(['read:user'])]
    public ?string $description = null;

    #[Groups(['read:user'])]
    public ?string $pathImage = null;

    #[Groups(['read:user'])]
    public ?int $level = null;
}
