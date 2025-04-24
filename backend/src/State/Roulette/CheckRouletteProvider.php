<?php

namespace App\State\Roulette;

use App\Entity\User;
use App\Service\RouletteService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CheckRouletteProvider implements ProviderInterface
{
    public function __construct(
        private ItemProvider $itemProvider,
        private RouletteService $rouletteService,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?JsonResponse
    {
        /** @var User|null $user */
        $user = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$user || $user->isDeleted()) {
            return new JsonResponse(['message' => 'Cet utilisateur n\'existe pas ou est bloqué.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $canPlay = $this->rouletteService->canPlay($user);

        return new JsonResponse(['message' => $canPlay], $canPlay ? JsonResponse::HTTP_OK : JsonResponse::HTTP_FORBIDDEN);
    }
}
