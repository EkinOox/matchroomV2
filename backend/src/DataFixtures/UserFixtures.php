<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Hotel;
use App\Entity\Feature;
use App\Entity\Negociation;
use Faker\Factory as Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Créer 3 hôtels à Aix-en-Provence avec des informations précises
        $hotels = [
            [
                'name' => 'Hôtel Aquabella & Spa Aix en Provence',
                'address' => '2 Rue des Étuves, 13100 Aix-en-Provence',
                'latitude' => 43.531113030806026,
                'longitude' => 5.444901132416444
            ],
            [
                'name' => 'Hôtel Adagio',
                'address' => '3-5 Rue des Chartreux, 13100 Aix-en-Provence',
                'latitude' => 43.52937258622414,
                'longitude' => 5.440867089934691
            ],
            [
                'name' => 'L\'Escapade Aixoise',
                'address' => '5 Rue de la Louvière, 13100 Aix-en-Provence',
                'latitude' => 43.53111497540869,
                'longitude' => 5.448076867987188
            ],
            [
                'name' => 'MGH - Massilia Green House',
                'address' => '31 Trav. Prat, 13008 Marseille',
                'latitude' => 43.242165585801224,
                'longitude' => 5.37155353054704
            ],
        ];

        // Création des objets hôtel et persistance
        $allHotels = [];
        foreach ($hotels as $hotelData) {
            $hotel = new Hotel();
            $hotel->setName($hotelData['name']);
            $hotel->setAdress($hotelData['address']);
            $hotel->setLatitude($hotelData['latitude']);
            $hotel->setLongitude($hotelData['longitude']);

            $manager->persist($hotel);

            $allHotels[] = $hotel;
        }

        // Créer une instance de Faker pour générer des données aléatoires
        $faker = Faker::create();

        // Créer 3 utilisateurs avec le rôle hôtelier et 3 utilisateurs sans ce rôle
        $hotelierUsers = [];
        $regularUsers = [];

        $user = new User();
        $user->setEmail("user@user.com");
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstname("Jane");
        $user->setLastname("DOE");
        $user->setRoles(['ROLE_HOTELIER']);
        $user->setHotel($allHotels[0]);
        $manager->persist($user);
        $hotelierUsers[] = $user;

        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $regularUsers[] = $user;
        }

        // Créer des caractéristiques (features)
        $features = [];
        $featureNames = [
            'Wi-Fi',
            'Parking',
            'Petit-déjeuner inclus',
            'Piscine',
            'Salle de sport',
            'Climatisation',
            'Spa',
            'Restaurant',
            'Bar',
            'Chambres familiales',
            'Navette aéroport',
            'Service d\'étage',
            'Animaux acceptés',
            'Jacuzzi',
            'Réception 24h/24'
        ];

        foreach ($featureNames as $name) {
            $feature = new Feature();
            $feature->setName($name);
            $manager->persist($feature);
            $features[] = $feature;
        }

        // Créer des chambres et associer des caractéristiques et des hôtels
        $rooms = [];
        for ($i = 0; $i < 4; $i++) { // Pour chaque hôtel
            for ($j = 1; $j <= 5; $j++) { // Créer 5 chambres par hôtel
                $room = new Room();
                $room->setName("Chambre $j");
                $room->setDescription("Description de la chambre $j à " . $allHotels[$i]->getName());
                $room->setPrice(100 + $j * 10); // Prix variable
                $room->setFolderImage("image$j.jpg");
                $room->setCapacity(2 + $j % 2); // Capacité variable
                $room->setAcceptanceThreshold(5);
                $room->setRefusalThreshold(2);

                // Associer chaque chambre à un hôtel
                $room->setHotel($allHotels[$i]);

                // Associer des caractéristiques aléatoires à chaque chambre
                $randomFeatures = array_rand($features, rand(2, 5)); // Choisir entre 2 et 5 caractéristiques aléatoires
                if (is_array($randomFeatures)) {
                    foreach ($randomFeatures as $index) {
                        $room->addFeature($features[$index]);
                    }
                } else {
                    $room->addFeature($features[$randomFeatures]);
                }

                $manager->persist($room);
                $rooms[] = $room;
            }
        }

        // Créer des négociations pour chaque hôtel et chaque chambre
        for ($i = 0; $i < 15; $i++) { // 3 hôtels x 5 chambres = 15 chambres
            $negociation = new Negociation();

            // Associer un utilisateur régulier (cycle parmi les 3 utilisateurs)
            $negociation->setUser($regularUsers[$i % 3]);

            // Associer une chambre à la négociation
            $negociation->setRoom($rooms[$i]);

            // Définir un prix proposé variable
            $negociation->setProposedPrice(150 + $i * 10); // Prix proposé variable

            // Statut initial
            $negociation->setStatus('pending');

            // Date de création
            $negociation->setCreatedAt(new \DateTimeImmutable());

            // Persist la négociation
            $manager->persist($negociation);
        }

        $manager->flush();
    }
}
