<?php

namespace App\State\Roulette;

use App\Entity\User;
use App\Service\RouletteService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use App\Repository\RoulettePrizeRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class PlayRouletteProvider implements ProviderInterface
{
    public function __construct(
        private ItemProvider $itemProvider,
        private RouletteService $rouletteService,
        #[Autowire(service: PersistProcessor::class)] private ProcessorInterface $persistProcessor,
        // private RoulettePrizeRepository $roulettePrizeRepository,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?JsonResponse
    {
        /** @var User|null $user */
        $user = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$user) {
            return new JsonResponse(['message' => 'Cet utilisateur n\'existe pas ou est bloqué.'], JsonResponse::HTTP_FORBIDDEN);
        }

        // Vérifier si l'utilisateur peut jouer
        if (!$this->rouletteService->canPlay($user)) {
            return new JsonResponse(['message' => false], JsonResponse::HTTP_FORBIDDEN);
        }

        // Choisir un gain aléatoire
        $prizes = $this->roulettePrizeRepository->findAll();

        // Calculer la somme totale des probabilités
        $totalProbability = array_sum(array_map(fn($prize) => $prize->getProbability(), $prizes));

        // Générer un nombre aléatoire entre 0 et 1
        $randomNumber = mt_rand() / mt_getrandmax();

        // Sélectionner un gain en fonction de la probabilité
        $currentProbability = 0;
        foreach ($prizes as $prize) {
            $currentProbability += $prize->getProbability() / $totalProbability;
            if ($randomNumber <= $currentProbability) {
                $selectedPrize = $prize;
                break;
            }
        }

        // Ajouter le gain à la balance de l'utilisateur
        $user->setBalance($user->getBalance() + $selectedPrize->getAmount());

        // Mettre à jour le dernier lancement de l'utilisateur
        $user->setLastLaunch(new \DateTimeImmutable());

        // Sauvegarder les modifications dans la base de données
        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        // Retourner la réponse avec le gain et la nouvelle balance
        return new JsonResponse([
            'message' => 'Vous avez gagné ' . $selectedPrize->getAmount() . ' coins',
            'prize' => $selectedPrize->getAmount(),
            'balance' => $user->getBalance()
        ], JsonResponse::HTTP_OK);
    }
}
