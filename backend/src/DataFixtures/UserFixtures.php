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
        // Créer une instance de Faker pour générer des données aléatoires
        $faker = Faker::create();

        // Créer 3 hôtels
        $hotels = [];
        for ($i = 1; $i <= 3; $i++) {
            $hotel = new Hotel();
            $hotel->setName("Hotel $i");
            $hotel->setAdress("Adresse de l'hôtel $i");
            $hotel->setLatitude(48.8566 + $i * 0.01);
            $hotel->setLongitude(2.3522 + $i * 0.01);
            $manager->persist($hotel);
            $hotels[] = $hotel;
        }

        // Créer 3 utilisateurs avec le rôle hôtelier et 3 utilisateurs sans ce rôle
        $hotelierUsers = [];
        $regularUsers = [];

        $user = new User();
        $user->setEmail("user@user.com");
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstname("Jane");
        $user->setLastname("DOE");
        $user->setRoles(['ROLE_HOTELIER']);
        $user->setHotel($hotels[1]);
        $manager->persist($user);
        $hotelierUsers[] = $user;

        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("hotelier$i@example.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setRoles(['ROLE_HOTELIER']);
            $user->setHotel($hotels[$i - 1]);
            $manager->persist($user);
            $hotelierUsers[] = $user;
        }

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
        $featureNames = ['Wi-Fi', 'Parking', 'Petit-déjeuner inclus', 'Piscine', 'Salle de sport', 'Climatisation'];

        foreach ($featureNames as $name) {
            $feature = new Feature();
            $feature->setName($name);
            $manager->persist($feature);
            $features[] = $feature;
        }

        $rooms = [];
        // Créer des chambres et associer des caractéristiques et des hôtels
        for ($i = 1; $i <= 9; $i++) {
            $room = new Room();
            $room->setName("Chambre $i");
            $room->setDescription("Description de la chambre $i");
            $room->setPrice(100 + $i * 10); // Prix variable
            $room->setFolderImage("image$i.jpg");
            $room->setCapacity(2 + $i % 2); // Capacité variable
            $room->setAcceptanceThreshold(5);
            $room->setRefusalThreshold(2);

            // Associer chaque chambre à un hôtel
            $room->setHotel($hotels[($i - 1) % 3]);

            // Associer des caractéristiques aléatoires à chaque chambre
            $randomFeatures = array_rand($features, rand(1, count($features)));
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

        // Créer des négociations pour chaque hôtel
        for ($i = 1; $i <= 9; $i++) {
            $negociation = new Negociation();
            $negociation->setUser($regularUsers[($i - 1) % 3]); // Utiliser les utilisateurs réguliers
            $negociation->setRoom($rooms[$i - 1]); // Utiliser les chambres stockées dans le tableau
            $negociation->setProposedPrice(150 + $i * 10); // Prix proposé variable
            $negociation->setStatus('pending'); // Statut initial
            $negociation->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($negociation);
        }

        $manager->flush();
    }
}
