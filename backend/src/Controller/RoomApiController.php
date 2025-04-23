<?php

namespace App\Controller;

use App\Entity\Feature;
use App\Entity\Room;
use App\Repository\FeatureRepository;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RoomApiController extends AbstractController
{
    #[Route('/api/creat_room', name: 'api_create_room', methods: ['POST'])]
    public function createRoom(Request $request, EntityManagerInterface $em, HotelRepository $hotelRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        // On récupère l’hôtel lié à la room
        $hotel = $hotelRepo->find($data['hotel_id'] ?? null);
        if (!$hotel) {
            return $this->json(['error' => 'Hotel not found'], 404);
        }

        $room = new Room();
        $room->setHotel($hotel);
        $room->setName($data['Name'] ?? '');
        $room->setDescription($data['description'] ?? '');
        $room->setPrice($data['price'] ?? 0);
        $room->setAcceptanceThreshold($data['acceptance_threshold'] ?? 0);
        $room->setRefusalThreshold($data['refusal_threshold'] ?? 0);
        $room->setCapacity($data['capacity'] ?? 1);
        $room->setFolderImage($data['image'] ?? '');
        $room->setTradingThreshold($data['trading_threshold'] ?? 0);

        if (!empty($data['features']) && is_array($data['features'])) {
            foreach ($data['features'] as $featureId) {
                $feature = $em->getRepository(Feature::class)->find($featureId);
                if ($feature) {
                    $room->addFeature($feature);
                }
            }
        }

        $em->persist($room);
        $em->flush();

        return $this->json([
            'success' => true,
            'room_id' => $room->getId(),
        ]);
    }

    #[Route('/api/delete_room/{id}', name: 'api_delete_room', methods: ['DELETE'])]
    public function deleteRoom(int $id, EntityManagerInterface $em): JsonResponse
    {
        $room = $em->getRepository(Room::class)->find($id);

        if (!$room) {
            return $this->json(['error' => 'Room not found'], 404);
        }

        $em->remove($room);
        $em->flush();

        return $this->json(['success' => true, 'message' => 'Room deleted successfully']);
    }

    #[Route('/api/update_room/{id}', name: 'api_update_room', methods: ['PUT'])]
    public function updateRoom(int $id, Request $request, EntityManagerInterface $em, FeatureRepository $featureRepository): JsonResponse
    {
        $room = $em->getRepository(Room::class)->find($id);

        if (!$room) {
            return $this->json(['error' => 'Room not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // Mise à jour des champs (si présents dans le JSON)
        if (isset($data['Name'])) $room->setName($data['Name']);
        if (isset($data['description'])) $room->setDescription($data['description']);
        if (isset($data['price'])) $room->setPrice($data['price']);
        if (isset($data['acceptance_threshold'])) $room->setAcceptanceThreshold($data['acceptance_threshold']);
        if (isset($data['refusal_threshold'])) $room->setRefusalThreshold($data['refusal_threshold']);
        if (isset($data['trading_threshold'])) $room->setTradingThreshold($data['trading_threshold']);
        if (isset($data['capacity'])) $room->setCapacity($data['capacity']);
        if (isset($data['image'])) $room->setFolderImage($data['image']);

        $newFeatureIds = isset($data['features']) ? $data['features'] : [];

        if (!empty($newFeatureIds)) {
            $currentFeatures = $room->getFeatures();
        
            // D'abord, retirer les features qui ne sont plus dans la nouvelle liste
            foreach ($currentFeatures as $feature) {
                if (!in_array($feature->getId(), $newFeatureIds)) {
                    $room->removeFeature($feature);
                }
            }
        
            // Puis, ajouter les nouvelles features non encore liées
            foreach ($newFeatureIds as $featureId) {
                $feature = $featureRepository->find($featureId);
                if ($feature && !$room->getFeatures()->contains($feature)) {
                    $room->addFeature($feature);
                }
            }
        }
        
        $em->flush();

        return $this->json(['success' => true, 'message' => 'Room updated']);
    }

}
