<?php

namespace App\Dto\Negociation;

use Symfony\Component\Serializer\Annotation\Groups;

class NegociationUpdateStatusDTO
{

    #[Groups(['negociation:patch'])]
    public string $status;

    #[Groups(['negociation:patch'])]
    public ?float $counterOffer = null;
}
