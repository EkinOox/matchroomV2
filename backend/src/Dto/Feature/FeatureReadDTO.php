<?php

namespace App\Dto\Feature;

use Symfony\Component\Serializer\Annotation\Groups;

final class FeatureReadDTO
{
    #[Groups(['read:feature', 'read:room', 'readSearch:room', 'read:room_negotiation'])]
    public ?int $id = null;

    #[Groups(['read:feature', 'read:room', 'readSearch:room', 'read:room_negotiation'])]
    public ?string $name = null;
}
