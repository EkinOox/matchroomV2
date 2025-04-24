<?php

namespace App\Controller;

use App\Entity\Negociation;
use App\Enum\NegociationStatus;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NegociationApiController extends AbstractController
{
    #[Route('/api/create_negociations', name: 'api_create_negociation', methods: ['POST'])]
    public function createNegociation(
        Request $request,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        RoomRepository $roomRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $userId = $data['user_id'] ?? null;
        $roomId = $data['room_id'] ?? null;
        $proposedPrice = $data['proposed_price'] ?? null;

        if (!$userId || !$roomId || !$proposedPrice) {
            return $this->json(['error' => 'Missing parameters'], 400);
        }

        $user = $userRepository->find($userId);
        $room = $roomRepository->find($roomId);

        if (!$user || !$room) {
            return $this->json(['error' => 'User or Room not found'], 404);
        }

        $negociation = new Negociation();
        $negociation->setUser($user);
        $negociation->setRoom($room);
        $negociation->setProposedPrice($proposedPrice);
        $negociation->setStatus(NegociationStatus::PENDING);
        $negociation->setCreatedAt(new \DateTimeImmutable());

        $em->persist($negociation);
        $em->flush();

        return $this->json([
            'success' => true,
            'negociation_id' => $negociation->getId(),
            'status' => $negociation->getStatus()
        ]);
    }

    #[Route('/api/negociation/{id}/refuse', name: 'api_refuse_negociation', methods: ['PUT'])]
    public function refuseNegociation(int $id, EntityManagerInterface $em): JsonResponse
    {
        $negociation = $em->getRepository(Negociation::class)->find($id);

        if (!$negociation) {
            return $this->json(['error' => 'Negotiation not found'], 404);
        }

        $negociation->setStatus(NegociationStatus::REFUSED);
        $negociation->setResponseTime(new \DateTimeImmutable());

        $em->flush();

        return $this->json([
            'success' => true,
            'message' => 'Negotiation refused',
            'negociation_id' => $negociation->getId()
        ]);
    }
}
