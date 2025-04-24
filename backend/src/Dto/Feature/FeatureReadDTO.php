<?php

namespace App\Dto\Feature;

use Symfony\Component\Serializer\Annotation\Groups;

final class FeatureReadDTO
{
    #[Groups(['read:feature', 'read:room', 'readSearch:room'])]
    public ?int $id = null;

    #[Groups(['read:feature', 'read:room', 'readSearch:room'])]
    public ?string $name = null;
}
