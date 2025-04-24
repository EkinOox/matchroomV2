<?php

namespace App\ApiResource\RoomNegociation;

use App\Dto\Room\RoomNegociationReadDTO;
use App\State\RoomNegociation\RoomNegociationCollectionProvider;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Negociation;

#[ApiResource(
    shortName: 'RoomNegociation',
    stateOptions: new Options(
        entityClass: Negociation::class,
    ),
    paginationEnabled: true,
    operations: [
        new GetCollection(
            uriTemplate: '/hotelier/rooms/negotiations',
            name: 'hotelierRoomsNegociationsGetCollection',
            security: "is_granted('ROLE_HOTELIER')",
            paginationEnabled: true,
            provider: RoomNegociationCollectionProvider::class,
            description: 'Récupérer la liste de toutes les chambres de l’hôtel de l’utilisateur hôtelier qui sont en négociation et qui n’ont pas le statut "finish".',
            normalizationContext: ['groups' => ['read:room_negotiation']],
            output: RoomNegociationReadDTO::class,
            openapi: new Model\Operation(
                tags: ['Hotelier_Room_Negociation'],
                summary: 'Récupération de la collection des chambres en négociation de l’hôtel de l’utilisateur hôtelier, avec pagination.',
            )
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact', 'room.hotel.id' => 'exact'])]
class RoomNegociationResource {}
