<?php
namespace App\ApiResource\RoomNegociation;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Link;
use App\Dto\Negociation\NegociationUpdateStatusDTO;
use App\Entity\Negociation;
use App\State\RoomNegociation\NegociationUpdateStatuProvider;

#[ApiResource(
    shortName: 'Hotelier_Room_Negociation',
    stateOptions: new Options(
        entityClass: Negociation::class,
    ),
    operations: [
        new Patch(
            uriTemplate: '/negociations/{id}/update_status',
            uriVariables: [
                'id' => new Link(fromClass: Negociation::class, identifiers: ['id']),
            ],
            input: NegociationUpdateStatusDTO::class,
            processor: NegociationUpdateStatuProvider::class,
            security: "is_granted('ROLE_HOTELIER')",
            denormalizationContext: ['groups' => ['negociation:patch']]
        )
    ]
)]
class NegociationUpdateStatusResource
{
}
