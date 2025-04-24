<?php

namespace App\ApiResource\RoomNegociation;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\Negociation\NegociationInput;
use App\Entity\Negociation;
use App\State\RoomNegociation\NegociationCreateProcessor ;

#[ApiResource(
    shortName: 'add_Negociation',
    stateOptions: new Options(
        entityClass: Negociation::class,
    ),
    paginationEnabled: true,
    operations: [
        new Post(
            uriTemplate: '/negociations',
            input: NegociationInput::class,
            processor: NegociationCreateProcessor::class,
            security: "is_granted('ROLE_USER')",
            denormalizationContext: ['groups' => ['negociation:write']]
        )
    ]
)]
final class NegociationInputRessource
{
}