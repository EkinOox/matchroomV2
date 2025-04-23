<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Badge;
use App\Entity\Hotel;
use DateTimeImmutable;
use App\Entity\Feature;
use App\Entity\Reservation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création des badges
        $badge1 = new Badge();
        $badge1->setName("Premier séjour")
            ->setDescription("Premier séjour effectué.")
            ->setPathImage("path_to_image_1")
            ->setLevel(1);
        $manager->persist($badge1);

        $badge2 = new Badge();
        $badge2->setName("Client fidèle")
            ->setDescription("Client ayant effectué 5 réservations.")
            ->setPathImage("path_to_image_2")
            ->setLevel(2);
        $manager->persist($badge2);

        $badge3 = new Badge();
        $badge3->setName("Super client")
            ->setDescription("Client ayant effectué 10 réservations.")
            ->setPathImage("path_to_image_3")
            ->setLevel(3);
        $manager->persist($badge3);

        // Création des features (caractéristiques des chambres)
        $features = [];
        for ($i = 0; $i < 5; $i++) {
            $feature = new Feature();
            $feature->setName($faker->word);
            $manager->persist($feature);
            $features[] = $feature;
        }

        // Création des hôtels
        $hotels = [];
        for ($i = 0; $i < 10; $i++) {
            $hotel = new Hotel();
            $hotel->setName("Hôtel " . $faker->word)
                ->setAdress("Aix-en-Provence, France")
                ->setLatitude(43.529742)
                ->setLongitude(5.447427)
                ->setCreatedAt(new DateTimeImmutable());
            $manager->persist($hotel);
            $hotels[] = $hotel;

            // Création des chambres pour chaque hôtel
            for ($j = 0; $j < 5; $j++) {
                $room = new Room();
                $room->setName("Chambre " . $faker->word)
                    ->setDescription("Super chambre")
                    ->setPrice($faker->randomFloat(2, 50, 500))
                    ->setHotel($hotel)
                    ->setCapacity(rand(1, 4))
                    ->setFolderImage($faker->imageUrl(400, 300))
                    ->setAcceptanceThreshold(rand(0, 100))
                    ->setRefusalThreshold(rand(0, 100))
                    ->setTradingThreshold(rand(0, 100));

                // Associer des caractéristiques (features) aux chambres
                for ($k = 0; $k < rand(1, 3); $k++) {  // Associer entre 1 et 3 features
                    $room->addFeature($features[array_rand($features)]);
                }
                // $this->logger->debug('Feature créée : ' . $feature->getName());
                $manager->persist($room);

                // Création de négociations pour chaque chambre
                // $negociation = new Negociation();
                // $negociation->setRoom($room)
                //     ->setUser(null) // Associer un utilisateur ici plus tard
                //     ->setProposedPrice($room->getPrice())
                //     ->setStatus('Proposée')
                //     ->setCreatedAt(new DateTimeImmutable());
                // $manager->persist($negociation);
            }
        }

        // Création des utilisateurs (3 utilisateurs classiques et 3 hôteliers)
        $users = [];
        for ($i = 0; $i < 6; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setCreatedAt(new DateTimeImmutable());

            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);

            if ($i < 3) {
                $user->setRoles(['ROLE_USER']);
            } else {
                $user->setRoles(['ROLE_HOTELIER']);
                $user->setHotel($hotels[$i - 3]); // Associer un hôtel aux hôteliers
            }

            $manager->persist($user);
            $users[] = $user;

            // Création des réservations pour certains utilisateurs
            // if ($i < 3) {
            //     $reservation = new Reservation();
            //     $reservation->setRoom($hotels[$i]->getRooms()->first()) // Associe une chambre existante
            //         ->setUser($user)
            //         ->setStartedAt(new DateTimeImmutable())
            //         ->setEndAt((new DateTimeImmutable())->modify('+3 days'))
            //         ->setCreatedAt(new DateTimeImmutable());
            //     $manager->persist($reservation);
            // }
        }

        $manager->flush();
    }
}
