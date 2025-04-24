<?php

namespace App\ApiResource\RoomNegociation;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\Negociation\NegociationOutput;
use App\State\RoomNegociation\NegociationCollectionProvider;

#[ApiResource(
    shortName: 'list_negociations',
    operations: [
        new GetCollection(
            uriTemplate: '/my/negociations',
            output: NegociationOutput::class,
            provider: NegociationCollectionProvider::class,
            security: "is_granted('ROLE_USER')",
            normalizationContext: ['groups' => ['negociation:read']]
        )
    ]
)]
final class NegociationOutputResource
{
}
