<?php

namespace App\ApiResource\Roulette;

use App\Entity\User;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
// use App\State\Roulette\PlayRouletteProvider;
use App\State\Roulette\CheckRouletteProvider;
use ApiPlatform\OpenApi\Model;


// #[ApiResource(
//     stateOptions: new Options(
//         entityClass: User::class,
//     ),
//     operations: [
//         new Get(
//             uriTemplate: '/roulette/check/{id}',
//             provider: CheckRouletteProvider::class,
//             name: 'checkRoulette',
//             security: "is_granted('IS_AUTHENTICATED_FULLY') and user.getId() == request.attributes.get('id')",
//             description: 'Vérifier si l’utilisateur peut jouer à la roulette',
//             openapi: new Model\Operation(
//                 tags: ['Roulette'],
//                 summary: 'Vérifier si l’utilisateur peut jouer à la roulette',
//                 parameters: [
//                     new Model\Parameter(
//                         name: 'id',
//                         in: 'path',
//                         description: 'Identifiant unique du User (ID)',
//                         required: true,
//                         schema: ['type' => 'string']
//                     )
//                 ],
//                 responses: [
//                     '200' => [
//                         'description' => 'L’utilisateur peut jouer',
//                         'content' => [
//                             'application/json' => [
//                                 'schema' => [
//                                     'type' => 'object',
//                                     'properties' => [
//                                         'message' => ['type' => 'boolean', 'example' => true],
//                                     ]
//                                 ]
//                             ]
//                         ]
//                     ],
//                     '403' => [
//                         'description' => 'L’utilisateur ne peut pas jouer',
//                         'content' => [
//                             'application/json' => [
//                                 'schema' => [
//                                     'type' => 'object',
//                                     'properties' => [
//                                         'message' => ['type' => 'boolean', 'example' => false],
//                                     ]
//                                 ]
//                             ]
//                         ]
//                     ],
//                 ]
//             )
//         ),
//         new Get(
//             uriTemplate: '/roulette/play/{id}',
//             // provider: PlayRouletteProvider::class,
//             name: 'playRoulette',
//             security: "is_granted('IS_AUTHENTICATED_FULLY') and user.getId() == request.attributes.get('id')",
//             description: 'Jouer à la roulette et obtenir un gain',
//             openapi: new Model\Operation(
//                 tags: ['Roulette'],
//                 summary: 'Jouer à la roulette et obtenir un gain',
//                 parameters: [
//                     new Model\Parameter(
//                         name: 'id',
//                         in: 'path',
//                         description: 'Identifiant unique du User (ID)',
//                         required: true,
//                         schema: ['type' => 'string']
//                     )
//                 ],
//                 responses: [
//                     '200' => [
//                         'description' => 'L’utilisateur a gagné et la balance a été mise à jour',
//                         'content' => [
//                             'application/json' => [
//                                 'schema' => [
//                                     'type' => 'object',
//                                     'properties' => [
//                                         'message' => ['type' => 'string', 'example' => 'Vous avez gagné 100 coins'],
//                                         'prize' => ['type' => 'integer', 'example' => 100],
//                                         'balance' => ['type' => 'integer', 'example' => 500],
//                                     ]
//                                 ]
//                             ]
//                         ]
//                     ],
//                     '403' => [
//                         'description' => 'L’utilisateur ne peut pas jouer',
//                         'content' => [
//                             'application/json' => [
//                                 'schema' => [
//                                     'type' => 'object',
//                                     'properties' => [
//                                         'message' => ['type' => 'string', 'example' => 'false'],
//                                     ]
//                                 ]
//                             ]
//                         ]
//                     ]
//                 ]
//             )
//         )
//     ]
// )]
class RouletteResource {}
