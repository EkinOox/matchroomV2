<?php

namespace App\Controller;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class HotelApiController extends AbstractController
{
    #[Route('/api/Create_hotel', name: 'api_create_hotel', methods: ['POST'])]
    public function createHotel(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Tu peux faire une validation ici
        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $hotel = new Hotel();
        $hotel->setName($data['name'] ?? '');
        $hotel->setAdress($data['adress'] ?? '');
        $hotel->setLongithude($data['longithude'] ?? 0);
        $hotel->setLatitude($data['latitude'] ?? 0);
        $hotel->setUserId($data['user_id'] ?? 0);
        $hotel->setDateCreation(new \DateTime());

        $em->persist($hotel);
        $em->flush();

        return $this->json([
            'success' => true,
            'hotel_id' => $hotel->getId(),
        ]);
    }

}
