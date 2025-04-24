<?php

namespace App\State\Room;

use App\Entity\Room;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @implements ProcessorInterface<Room, void>
 */
final class RoomDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        private TokenStorageInterface $tokenStorage,
        private ManagerRegistry $managerRegistry
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if (!$operation instanceof DeleteOperationInterface) {
            throw new \LogicException('This processor only supports delete operations.');
        }

        /** @var Room $room */
        $room = $data;

        // Récupérer l'utilisateur connecté
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            throw new \LogicException('The security token should be available.');
        }

        /** @var User $user */
        $user = $token->getUser();
        if (null === $user) {
            throw new \LogicException('Utilisateur invalide.');
        }

        $hotel = $user->getHotel();
        if (null === $hotel) {
            throw new \LogicException('L\'utilisateur n\'est associé à aucun hôtel.');
        }

        // Vérifier si la chambre appartient à l'hôtel de l'utilisateur
        if ($room->getHotel()->getId() !== $hotel->getId()) {
            throw new AccessDeniedHttpException('Vous n\'avez pas la permission de supprimer cette chambre.');
        }

        // Supprimer la chambre via le removeProcessor
        $this->removeProcessor->process($room, $operation, $uriVariables, $context);
    }
}
