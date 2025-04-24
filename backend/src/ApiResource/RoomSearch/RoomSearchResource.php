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
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'application/json' => new Model\MediaType(
                            schema: new \ArrayObject([
                                'type' => 'object',
                                'properties' => [
                                    'longitude' => [
                                        'type' => 'number',
                                        'format' => 'float',
                                        'example' => 5.371553530547,
                                        'description' => 'Coordonnée longitude'
                                    ],
                                    'latitude' => [
                                        'type' => 'number',
                                        'format' => 'float',
                                        'example' => 43.242165585801,
                                        'description' => 'Coordonnée latitude'
                                    ],
                                    'NbVoyageur' => [
                                        'type' => 'integer',
                                        'example' => 2,
                                        'description' => 'Nombre de voyageurs'
                                    ],
                                    'critere' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'integer'
                                        ],
                                        'example' => [41, 44, 51],
                                        'description' => 'IDs des critères de recherche'
                                    ]
                                ],
                                'required' => ['longitude', 'latitude', 'NbVoyageur', 'critere']
                            ])
                        )
                    ])
                ),
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
