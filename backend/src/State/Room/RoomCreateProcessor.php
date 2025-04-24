<?php

// namespace App\State\Room;

// use App\Entity\Room;
// use App\Entity\Feature;
// use App\Dto\Room\RoomCreateDTO;
// use ApiPlatform\Metadata\Operation;
// use ApiPlatform\State\ProcessorInterface;
// use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use ApiPlatform\Doctrine\Common\State\PersistProcessor;
// use Symfony\Component\DependencyInjection\Attribute\Autowire;
// use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

// /**
//  * @implements ProcessorInterface<RoomCreateDTO, Room>
//  */
// final class RoomCreateProcessor implements ProcessorInterface
// {
//     public function __construct(
//         #[Autowire(service: PersistProcessor::class)]
//         private ProcessorInterface $persistProcessor,
//         private TokenStorageInterface $tokenStorage,
//         private ManagerRegistry $managerRegistry
//     ) {}

//     public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
//     {
//         /** @var RoomCreateDTO $data */
//         $room = new Room();
//         $room->setName($data->name);
//         $room->setDescription($data->description);
//         $room->setPrice($data->price);
//         $room->setFolderImage($data->folderImage);
//         $room->setCapacity($data->capacity);
//         $room->setAcceptanceThreshold($data->acceptanceThreshold);
//         $room->setRefusalThreshold($data->refusalThreshold);

//         // Récupérer l'utilisateur connecté
//         $token = $this->tokenStorage->getToken();
//         if (null === $token) {
//             throw new \LogicException('The security token should be available.');
//         }

//         /** @var User $user */
//         $user = $token->getUser();
//         if (null === $user) {
//             throw new \LogicException('Utilisateur invalide.');
//         }

//         $hotel = $user->getHotel();
//         if (null === $hotel) {
//             throw new \LogicException('L\'utilisateur n\'est associé à aucun hôtel.');
//         }

//         // Associer la chambre à l'hôtel de l'utilisateur
//         $room->setHotel($hotel);

//         // Associer les caractéristiques à la chambre
//         if (!empty($data->features)) {
//             $featureRepository = $this->managerRegistry->getRepository(Feature::class);
//             foreach ($data->features as $featureId) {
//                 $feature = $featureRepository->find($featureId);
//                 if (!$feature) {
//                     throw new BadRequestHttpException(sprintf('Feature with ID %s not found.', $featureId));
//                 }
//                 $room->addFeature($feature);
//             }
//         }

//         // Sauvegarde via le persistProcessor
//         $this->persistProcessor->process($room, $operation, $uriVariables, $context);

//         return new JsonResponse(['message' => 'Chambre créée avec succès'], JsonResponse::HTTP_CREATED);
//     }
// }


namespace App\State\Room;

use App\Entity\Room;
use App\Entity\Feature;

use App\Dto\Room\RoomCreateDTO;
use App\Dto\Room\RoomReadDTO;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @implements ProcessorInterface<RoomCreateDTO, RoomReadDTO>
 */
final class RoomCreateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: PersistProcessor::class)]
        private ProcessorInterface $persistProcessor,
        private TokenStorageInterface $tokenStorage,
        private ManagerRegistry $managerRegistry
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RoomReadDTO
    {
        /** @var RoomCreateDTO $data */
        $room = new Room();
        $room->setName($data->name);
        $room->setDescription($data->description);
        $room->setPrice($data->price);
        $room->setFolderImage($data->folderImage);
        $room->setCapacity($data->capacity);
        $room->setAcceptanceThreshold($data->acceptanceThreshold);
        $room->setRefusalThreshold($data->refusalThreshold);

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

        // Associer la chambre à l'hôtel de l'utilisateur
        $room->setHotel($hotel);

        // Associer les caractéristiques à la chambre
        if (!empty($data->features)) {
            $featureRepository = $this->managerRegistry->getRepository(Feature::class);
            foreach ($data->features as $featureId) {
                $feature = $featureRepository->find($featureId);
                if (!$feature) {
                    throw new BadRequestHttpException(sprintf('Feature with ID %s not found.', $featureId));
                }
                $room->addFeature($feature);
            }
        }

        // Sauvegarde via le persistProcessor
        $this->persistProcessor->process($room, $operation, $uriVariables, $context);

        // Mapper l'entité Room créée vers RoomReadDTO
        return $this->mapToDto($room);
    }

    private function mapToDto(Room $room): RoomReadDTO
    {
        $dto = new RoomReadDTO();
        $dto->id = $room->getId();
        $dto->name = $room->getName();
        $dto->description = $room->getDescription();
        $dto->price = $room->getPrice();
        $dto->folderImage = $room->getFolderImage();
        $dto->capacity = $room->getCapacity();
        $dto->acceptanceThreshold = $room->getAcceptanceThreshold();
        $dto->refusalThreshold = $room->getRefusalThreshold();
        $dto->createdAt = $room->getCreatedAt();

        // Mapper les caractéristiques
        foreach ($room->getFeatures() as $feature) {
            $featureDto = new \App\Dto\Feature\FeatureReadDTO();
            $featureDto->id = $feature->getId();
            $featureDto->name = $feature->getName();
            $dto->features[] = $featureDto;
        }

        return $dto;
    }
}
