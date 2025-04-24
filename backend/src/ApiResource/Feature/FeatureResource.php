<?php

namespace App\ApiResource\Feature;

use App\Entity\Feature;
use ApiPlatform\OpenApi\Model;
use App\Dto\Feature\FeatureReadDTO;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\State\Feature\FeatureCollectionProvider;

#[ApiResource(
    shortName: 'Feature',
    stateOptions: new Options(
        entityClass: Feature::class,
    ),
    paginationEnabled: false,
    operations: [
        new GetCollection(
            uriTemplate: '/features',
            name: 'featureCollection',
            paginationEnabled: false,
            provider: FeatureCollectionProvider::class,
            description: 'Récupérer la liste de toutes les caractéristiques disponibles.',
            normalizationContext: ['groups' => ['read:feature']],
            output: FeatureReadDTO::class,
            openapi: new Model\Operation(
                tags: ['Features'],
                summary: 'Récupérer la liste des caractéristiques.',
            )
        ),

    ]
)]
class FeatureResource {}
