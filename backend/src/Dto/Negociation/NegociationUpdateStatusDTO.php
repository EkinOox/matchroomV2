<?php
namespace App\Dto\Negociation;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class NegociationUpdateStatusDTO
{
    #[Assert\NotBlank]
    #[Groups(['negociation:patch'])]
    public string $status;
}
