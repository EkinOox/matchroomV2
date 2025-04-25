<?php
namespace App\State\RoomNegociation;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\NegociationInput;
use App\Entity\Negociation;
use App\Enum\NegociationStatus;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NegociationCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private RoomRepository $roomRepository,
        private TokenStorageInterface $tokenStorage,
        private Security $security
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Negociation
    {
        
        /** @var NegociationInput $data */
        $user = $this->security->getUser();
        $roomId = (int) basename($data->room); // "/api/rooms/1" => "1"
        $room = $this->roomRepository->find($roomId);

        $negociation = new Negociation();
        $negociation->setUser($user);
        $negociation->setRoom($room);
        $negociation->setProposedPrice($data->proposedPrice);
        $negociation->setStatus(NegociationStatus::PENDING);
        $negociation->setCreatedAt(new \DateTimeImmutable());
        $negociation->setStartDate($data->startDate);
        $negociation->setEndDate($data->endDate);

        $this->em->persist($negociation);
        $this->em->flush();

        return $negociation;
    }
}
