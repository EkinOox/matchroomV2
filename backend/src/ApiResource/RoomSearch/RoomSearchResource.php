<?php

namespace App\ApiResource\RoomSearch;


use App\Dto\Room\RoomSearchReadDTO;
use App\Dto\Room\RoomSearchCreateDTO;
use App\State\RoomSearch\RoomSearchProcessor;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Room;

#[ApiResource(
    shortName: 'RoomSearch',
    stateOptions: new Options(
        entityClass: Room::class,
    ),
    paginationEnabled: false,
    operations: [
        new Post(
            uriTemplate: '/rooms/search',
            name: 'roomSearchPost',
            security: "is_granted('ROLE_USER')",
            input: RoomSearchCreateDTO::class,
            processor: RoomSearchProcessor::class,
            output: RoomSearchReadDTO::class,
            description: 'Rechercher des chambres en fonction des critères spécifiés.',
            normalizationContext: ['groups' => ['readSearch:room']],
            openapi: new Model\Operation(
                tags: ['RoomSearch'],
                summary: 'Recherche de chambres en fonction des critères spécifiés.',
            )
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'longitude' => 'exact',
    'latitude' => 'exact',
    'NbVoyageur' => 'exact',
])]
class RoomSearchResource {}
