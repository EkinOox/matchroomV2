<?php

namespace App\ApiResource\User;

use App\Entity\User;
use ApiPlatform\Metadata\Get;
use App\Dto\User\UserReadDTO;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Dto\User\UserPatchDTO;
use ApiPlatform\Metadata\Patch;
use App\Dto\User\UserCreateDTO;
use ApiPlatform\Metadata\Delete;
use App\State\User\UserReadProvider;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\User\Admin\AdminPatchDTO;
use App\Dto\User\Admin\AdminCreateDTO;
use App\State\SoftDeleteUserProcessor;
use App\State\User\UserPatchProcessor;
use ApiPlatform\Metadata\GetCollection;
use App\State\User\UserCreateProcessor;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Dto\User\Admin\AdminReadDTO;
use App\State\User\AdminCollectionProvider;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[ApiResource(
    shortName: 'User',
    stateOptions: new Options(
        entityClass: User::class,
    ),
    paginationEnabled: false,
    operations: [
        // new Post(
        //     uriTemplate: '/user',
        //     input: UserCreateDTO::class,
        //     processor: UserCreateProcessor::class,
        //     name: 'userPost',
        //     security: "is_granted('PUBLIC_ACCESS')",
        //     description: 'Créer un nouvel utilisateur avec un éventuel code de parrainage',
        //     denormalizationContext: [
        //         AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        //     ],
        //     openapi: new Model\Operation(
        //         summary: 'Inscription d’un nouvel utilisateur',
        //         requestBody: new Model\RequestBody(
        //             content: new \ArrayObject([
        //                 'application/json' => new Model\MediaType(
        //                     schema: new \ArrayObject([
        //                         'type' => 'object',
        //                         'properties' => [
        //                             'email' => ['type' => 'string', 'example' => 'test@example.com'],
        //                             'password' => ['type' => 'string', 'example' => 'MotDePasseSecure123!'],
        //                             'pseudo' => ['type' => 'string', 'example' => 'PseudoCool'],
        //                             'referralCode' => ['type' => 'string', 'example' => 'ABC123XYZ']
        //                         ],
        //                         'required' => ['email', 'password', 'pseudo']
        //                     ])
        //                 )
        //             ])
        //         ),
        //         responses: [
        //             '201' => [
        //                 'description' => 'Utilisateur créé avec succès',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'message' => ['type' => 'string', 'example' => 'Utilisateur créé avec succès']
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     )
        // ),
        // new Get(
        //     uriTemplate: '/user/{id}',
        //     provider: UserReadProvider::class,
        //     output: UserReadDTO::class,
        //     name: 'userGet',
        //     security: "is_granted('IS_AUTHENTICATED_FULLY') and user.getId() == request.attributes.get('id')",
        //     normalizationContext: [
        //         'groups' => ['read:user'],
        //         AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        //     ],
        //     description: 'Récupérer les informations de l’utilisateur connecté',
        //     openapi: new Model\Operation(
        //         summary: 'Récupération des infos de l’utilisateur connecté',
        //         responses: [
        //             '200' => [
        //                 'description' => 'Données de l’utilisateur',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'id' => ['type' => 'string', 'format' => 'uuid'],
        //                                 'email' => ['type' => 'string', 'example' => 'test@example.com'],
        //                                 'pseudo' => ['type' => 'string', 'example' => 'PseudoCool'],
        //                                 'balance' => ['type' => 'number', 'example' => 100],
        //                                 'createdAt' => ['type' => 'string', 'format' => 'date-time'],
        //                                 'updatedAt' => ['type' => 'string', 'format' => 'date-time'],
        //                                 'lastLaunch' => ['type' => 'string', 'format' => 'date-time', 'nullable' => true],
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     )
        // ),
        // new Patch(
        //     uriTemplate: '/user/{id}',
        //     input: UserPatchDTO::class,
        //     processor: UserPatchProcessor::class,
        //     name: 'userPatch',
        //     security: "is_granted('IS_AUTHENTICATED_FULLY') and user.getId() == request.attributes.get('id')",
        //     denormalizationContext: [
        //         'groups' => ['patch:user'],
        //         AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        //     ],
        //     description: 'Modifier son pseudo ou son mot de passe',
        //     openapi: new Model\Operation(
        //         summary: 'Mettre à jour le pseudo ou mot de passe de l’utilisateur connecté, puis faire une requête sur /refresh/token pour mettre à jour le token utilisateur',
        //         requestBody: new Model\RequestBody(
        //             content: new \ArrayObject([
        //                 'application/merge-patch+json' => new Model\MediaType(
        //                     schema: new \ArrayObject([
        //                         'type' => 'object',
        //                         'properties' => [
        //                             'pseudo' => ['type' => 'string', 'example' => 'NewPseudoCool'],
        //                             'currentPassword' => ['type' => 'string', 'example' => 'AncienMotDePasse123!'],
        //                             'newPassword' => ['type' => 'string', 'example' => 'NouveauMotDePasseUltraSecure456@']
        //                         ]
        //                     ])
        //                 )
        //             ])
        //         ),
        //         responses: [
        //             '200' => [
        //                 'description' => 'Utilisateur mis à jour avec succès',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'message' => ['type' => 'string', 'example' => 'Utilisateur mis à jour avec succès']
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             '400' => [
        //                 'description' => 'Erreur de validation ou mot de passe incorrect',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'message' => ['type' => 'string', 'example' => 'Le mot de passe actuel est requis pour changer le mot de passe.']
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     )
        // ),
        // // <-------------------------------------- Partie Admin --------------------------------------->

        // // Récupérer tous les utilisateurs pour l'admin (avec pagination)
        // new GetCollection(
        //     uriTemplate: '/admin/users',
        //     name: 'adminUsersGetCollection',
        //     security: "is_granted('ROLE_ADMIN')",
        //     paginationEnabled: true,
        //     provider: AdminCollectionProvider::class,
        //     description: 'Récupérer la liste de tous les utilisateurs en tant qu’administrateur',
        //     normalizationContext: ['groups' => ['read:admin']],
        //     output: AdminReadDTO::class,
        //     openapi: new Model\Operation(
        //         tags: ['Admin_User'],
        //         summary: 'Récupération de collection d’utilisateurs, avec pagination',
        //     )
        // ),
        // new Post(
        //     uriTemplate: '/admin/user',
        //     input: AdminCreateDTO::class,
        //     processor: UserCreateProcessor::class,
        //     name: 'adminUserPost',
        //     security: "is_granted('ROLE_ADMIN')",
        //     description: 'Créer un nouvel utilisateur en tant qu’administrateur',
        //     denormalizationContext: [
        //         AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        //     ],
        //     openapi: new Model\Operation(
        //         tags: ['Admin_User'],
        //         summary: 'Création d’un nouvel utilisateur par un administrateur',
        //         requestBody: new Model\RequestBody(
        //             content: new \ArrayObject([
        //                 'application/json' => new Model\MediaType(
        //                     schema: new \ArrayObject([
        //                         'type' => 'object',
        //                         'properties' => [
        //                             'email' => ['type' => 'string', 'example' => 'test@example.com'],
        //                             'password' => ['type' => 'string', 'example' => 'MotDePasseSecure123!'],
        //                             'pseudo' => ['type' => 'string', 'example' => 'PseudoCool'],
        //                             'roles' => ['type' => 'array', 'example' => ['ROLE_USER']],
        //                             'balance' => ['type' => 'number', 'example' => 100],
        //                             'referralCode' => ['type' => 'string', 'example' => 'ABC123XYZ']
        //                         ],
        //                         'required' => ['email', 'password', 'pseudo', 'roles']
        //                     ])
        //                 )
        //             ])
        //         ),
        //         responses: [
        //             '201' => [
        //                 'description' => 'Utilisateur créé avec succès',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'message' => ['type' => 'string', 'example' => 'Utilisateur créé avec succès']
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     )
        // ),
        // new Patch(
        //     uriTemplate: '/admin/user/{id}',
        //     name: 'adminUserPatch',
        //     security: "is_granted('ROLE_ADMIN')",
        //     input: AdminPatchDTO::class,
        //     processor: UserPatchProcessor::class,
        //     denormalizationContext: [
        //         'groups' => ['patch:admin'],
        //         AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        //     ],
        //     openapi: new Model\Operation(
        //         tags: ['Admin_User'],
        //         summary: 'Mettre à jour partiellement un utilisateur en tant qu\'administrateur',
        //         requestBody: new Model\RequestBody(
        //             content: new \ArrayObject([
        //                 'application/merge-patch+json' => new Model\MediaType(
        //                     schema: new \ArrayObject([
        //                         'type' => 'object',
        //                         'properties' => [
        //                             'email' => ['type' => 'string', 'example' => 'newemail@example.com'],
        //                             'pseudo' => ['type' => 'string', 'example' => 'NewPseudo'],
        //                             'password' => ['type' => 'string', 'example' => 'NewSecurePassword123!'],
        //                             'roles' => ['type' => 'array', 'items' => ['type' => 'string', 'example' => 'ROLE_ADMIN']],
        //                             'balance' => ['type' => 'number', 'example' => 500.0],
        //                         ]
        //                     ])
        //                 )
        //             ]),
        //         ),
        //         responses: [
        //             '200' => [
        //                 'description' => 'Utilisateur mis à jour avec succès',
        //                 'content' => [
        //                     'application/json' => [
        //                         'schema' => [
        //                             'type' => 'object',
        //                             'properties' => [
        //                                 'message' => ['type' => 'string', 'example' => 'Utilisateur mis à jour avec succès.'],
        //                             ],
        //                         ],
        //                     ],
        //                 ],
        //             ]
        //         ],
        //     ),
        // ),
        // new Delete(
        //     uriTemplate: '/admin/user/{id}',
        //     name: 'adminUserDelete',
        //     security: "is_granted('ROLE_ADMIN')",
        //     processor: SoftDeleteUserProcessor::class,
        //     openapi: new Model\Operation(
        //         tags: ['Admin_User'],
        //         summary: 'Suppression d’un utilisateur de manière douce (soft delete)',
        //     )
        // ),

        new Get(
            uriTemplate: '/user',
            provider: UserReadProvider::class,
            output: UserReadDTO::class,
            name: 'userGet',
            security: "is_granted('IS_AUTHENTICATED_FULLY')",
            normalizationContext: [
                'groups' => ['read:user'],
                AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
            ],
            description: 'Récupérer les informations de l’utilisateur connecté',
            openapi: new Model\Operation(
                summary: 'Récupération des infos de l’utilisateur connecté',
                responses: [
                    '200' => [
                        'description' => 'Données de l’utilisateur',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => ['type' => 'string', 'format' => 'uuid'],
                                        'email' => ['type' => 'string', 'example' => 'test@example.com'],
                                        'firstname' => ['type' => 'string', 'example' => 'John'],
                                        'lastname' => ['type' => 'string', 'example' => 'Doe'],
                                        'roles' => ['type' => 'array', 'items' => ['type' => 'string'], 'example' => ['ROLE_USER']],
                                        'createdAt' => ['type' => 'string', 'format' => 'date-time'],
                                        'updatedAt' => ['type' => 'string', 'format' => 'date-time'],
                                        'hotel' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'id' => ['type' => 'integer', 'example' => 1],
                                                'name' => ['type' => 'string', 'example' => 'Hotel Example'],
                                            ]
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            )
        ),

    ]
)]
class UserResource {}
