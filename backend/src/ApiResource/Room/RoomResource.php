<?php

namespace App\ApiResource\Room;

use App\Entity\Room;
use App\Dto\Room\RoomReadDTO;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Dto\Room\RoomCreateDTO;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\Room\RoomCreateProcessor;
use App\State\Room\RoomDeleteProcessor;
use App\State\Room\RoomCollectionProvider;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
    shortName: 'Room',
    stateOptions: new Options(
        entityClass: Room::class,
    ),
    paginationEnabled: true,
    operations: [
        new GetCollection(
            uriTemplate: '/hotelier/rooms',
            name: 'hotelierRoomsGetCollection',
            security: "is_granted('ROLE_HOTELIER')",
            paginationEnabled: true,
            provider: RoomCollectionProvider::class,
            description: 'Récupérer la liste de toutes les chambres de l’hôtel de l’utilisateur hôtelier',
            normalizationContext: ['groups' => ['read:room']],
            output: RoomReadDTO::class,
            openapi: new Model\Operation(
                tags: ['Hotelier_Room'],
                summary: 'Récupération de la collection des chambres de l’hôtel de l’utilisateur hôtelier, avec pagination',
            )
        ),
        new Post(
            uriTemplate: '/hotelier/rooms',
            name: 'hotelierRoomsPost',
            security: "is_granted('ROLE_HOTELIER')",
            input: RoomCreateDTO::class,
            processor: RoomCreateProcessor::class,
            output: RoomReadDTO::class,
            description: 'Créer une nouvelle chambre pour l’hôtel de l’utilisateur hôtelier',
            openapi: new Model\Operation(
                tags: ['Hotelier_Room'],
                summary: 'Création d’une nouvelle chambre pour l’hôtel de l’utilisateur hôtelier',
            ),
        ),
        new Delete(
            uriTemplate: '/hotelier/rooms/{id}',
            name: 'hotelierRoomsDelete',
            security: "is_granted('ROLE_HOTELIER')",
            processor: RoomDeleteProcessor::class,
            description: 'Supprimer une chambre de l’hôtel de l’utilisateur hôtelier',
            openapi: new Model\Operation(
                tags: ['Hotelier_Room'],
                summary: 'Suppression d’une chambre de l’hôtel de l’utilisateur hôtelier',
            ),
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['hotel.id' => 'exact'])]
class RoomResource {}
