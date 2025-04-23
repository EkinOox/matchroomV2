<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class HotelApiController extends AbstractController
{
    #[Route('/api/create_hotel', name: 'api_create_hotel', methods: ['POST'])]
    public function createHotel(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }
        $user = $em->getRepository(User::class)->find($data['user_id'] ?? 0);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }
        $hotel = new Hotel();
        $hotel->setName($data['name'] ?? '');
        $hotel->setAdress($data['adress'] ?? '');
        $hotel->setLongitude($data['longitude'] ?? 0);
        $hotel->setLatitude($data['latitude'] ?? 0);
        $hotel->setCreatedAt(new \DateTimeImmutable());
        $hotel->addUser($user);

        $em->persist($hotel);
        $em->flush();

        return $this->json([
            'success' => true,
            'hotel_id' => $hotel->getId(),
        ]);
    }

}
