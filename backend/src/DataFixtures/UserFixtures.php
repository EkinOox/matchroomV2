<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Badge;
use App\Entity\Hotel;
use App\Entity\Feature;
use App\Entity\Negociation;
use App\Entity\Reservation;
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

        // Liste des images que vous avez fournies
        $images = [
            "https://woody.cloudly.space/app/uploads/lourdes/2021/10/thumbs/chambre-hotel-1920x960-crop-1635427113.jpg",
            "https://st.hzcdn.com/simgs/pictures/chambres/duplex-parisien-master-s-bedroom-sarah-lavoine-studio-d-architecture-d-interieur-img~ec41b5b603b67463_14-2471-1-17bed26.jpg",
            "https://www.hotelarmoniparis.com/_novaimg/galleria/1535876.jpg",
            "https://media.tarkett-image.com/small/IN_401_Hospitality_Luxury_Bedrooms_001.jpg",
            "https://www.shutterstock.com/image-photo/interior-hotel-bedroom-600nw-2496648857.jpg",
            "https://media.istockphoto.com/id/850632872/fr/photo/luxe-de-rendu-3d-et-moderne-salle-de-s%C3%A9jour-avec-canap%C3%A9-en-cuir-de-bonne-conception.jpg?s=612x612&w=0&k=20&c=079TBRikwC-LQZ8ck11hnpdqS53lcEhZMv8Uqjfeizg=",
            "https://cdn.prod.website-files.com/5faeb38cb5f86ba2c2288cd3/626694f0059766639f128992_deluxe%20king%20room%201.png",
            "https://poitoux.fr/wp-content/uploads/2020/01/Como_VF_2-dernier-web.jpg",
            "https://d1vp8nomjxwyf1.cloudfront.net/wp-content/uploads/sites/365/2021/03/24163452/ChambreAmourSup%C3%A9rieure-bleue-rose-%40pionphotographie-3.jpg",
            "https://www.yonder.fr/sites/default/files/styles/lg-insert/public/contenu/destinations/5%20Codet%20chambre%20%C2%A9%20Antoine%20Schramm_0.jpg?itok=jv3m9LdX",
            "https://www.hotelbdesign.fr/wp-content/uploads/2017/12/suite-design-2.jpg",
            "https://www.hotelparisjadore.com/blog/wp-content/uploads/2021/07/pja-770x539.jpg",
            "https://media.istockphoto.com/id/1478976422/fr/vid%C3%A9o/int%C3%A9rieur-3d-de-chambre-sombre-murs-noirs-chambre-de-luxe-appartement-h%C3%B4tel-id%C3%A9e-de-design.jpg?s=640x640&k=20&c=65GdyPMptKGipInxD3AwU4IfgRxMSvJ_unaJASEVRXY=",
            "https://img-3.journaldesfemmes.fr/IrSleL1PB7xYFmRC6puNhB2Uzow=/1080x/smart/c060716785454fcc8215a9ac45d33733/ccmcms-jdf/37165266.jpg",
            "https://www.hotelfloridaparis.com/_novaimg/5275804-1541718_0_0_4800_3200_1200_800.jpg",
            "https://www.yonder.fr/sites/default/files/styles/lg-insert/public/contenu/destinations/small%20LES-BORDS-DE-MER_MARSEILLE-07269.jpg?itok=jPNZDhBl",
            "https://www.hotel-negresco-nice.com/sites/default/files/styles/750x500/public/2021-02/Le%20Negresco_Deluxe%20vue%20mer%20-%20ch218_%28c%29Anthony%20Lanneretonne_096_BD.jpg?h=98f4cc9f&itok=vjrDXvTP",
            "https://www.maybourneriviera.com/globalassets/riviera/room-page-listing-imagery/1.-new-rooms-2023/grand-sea-view-studio/french/fr-grand-sea-view-studio-hero-2-1920_1080.jpg",
            "https://cf.bstatic.com/xdata/images/hotel/max1024x768/595898487.jpg?k=80c0f48b0b89978578036139251cc214c218c33c3486f01d877de6da352a7c35&o=&hp=1",
            "https://resize.elle.fr/article/var/plain_site/storage/images/deco/reportages/city-guide/les-plus-belles-chambres-avec-vue-au-monde/ocean-suite-the-setai-miami-beach-vue-plage-de-south-beach-et-ocean-atlantique-miami/90693010-1-fre-FR/Ocean-Suite-The-Setai-Miami-Beach-vue-plage-de-South-Beach-et-ocean-Atlantique-Miami.jpg"
        ];

        $badges = [
            [
                'name' => 'Première Négociation',
                'description' => 'Bravo ! Vous avez réussi votre toute première négociation. Bienvenue dans le club des négociateurs !',
                'image' => '1.jpg',
                'level' => 1
            ],
            [
                'name' => '10 Négociations',
                'description' => 'Félicitations ! Vous avez négocié 10 fois. Vous êtes déjà un expert des bons plans !',
                'image' => '10.jpg',
                'level' => 2
            ],
            [
                'name' => '50 Négociations',
                'description' => 'Impressionnant ! 50 négociations et vous êtes devenu un véritable maître dans l’art de la négociation.',
                'image' => '50.jpg',
                'level' => 3
            ],
            [
                'name' => '100 Négociations',
                'description' => 'Incroyable ! Vous avez franchi la barre des 100 négociations. Vous êtes désormais une légende du voyageur malin.',
                'image' => '100.jpg',
                'level' => 4
            ],
            [
                'name' => 'Explorer Ultime',
                'description' => 'Vous êtes l’Explorateur Ultime ! 500 négociations et vous avez fait plus de deals que tout le monde ! Vous connaissez tous les secrets de l’hôtel.',
                'image' => '500.jpg',
                'level' => 5
            ]
        ];

        $allBadges = [];
        foreach ($badges as $badgeData) {
            $badge = new Badge();
            $badge->setName($badgeData['name'])
                ->setDescription($badgeData['description'])
                ->setPathImage($badgeData['image'])
                ->setLevel($badgeData['level']);
            $manager->persist($badge);
            $allBadges[] = $badge;
        }

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

        // Création des objets utilisateur et persistance
        $faker = Faker::create();

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
            $user->addBadge($allBadges[$i]);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $regularUsers[] = $user;
        }

        // Création des caractéristiques (features)
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

        // Création des chambres et associer des caractéristiques et des hôtels
        $rooms = [];
        $imageIndex = 0;
        for ($i = 0; $i < 4; $i++) { // Pour chaque hôtel
            for ($j = 1; $j <= 5; $j++) { // Créer 5 chambres par hôtel
                $room = new Room();
                $room->setName("Chambre $j");
                $room->setDescription("Description de la chambre $j à " . $allHotels[$i]->getName());
                $room->setPrice(100 + $j * 10); // Prix variable
                $room->setFolderImage($images[$imageIndex]);
                $room->setCapacity(2 + $j % 2); // Capacité variable
                $room->setAcceptanceThreshold(80);
                $room->setRefusalThreshold(50);

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

                // Incrémenter l'index pour l'image
                $imageIndex++;

                $manager->persist($room);
                $rooms[] = $room;
            }
        }

        // Création des négociations pour chaque hôtel et chaque chambre
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

            $negociation->setStartDate(new \DateTimeImmutable());
            $negociation->setEndDate(new \DateTimeImmutable('+5 day'));

            // Date de création
            $negociation->setCreatedAt(new \DateTimeImmutable());

            // Persist la négociation
            $manager->persist($negociation);
        }

        // Création des réservations pour chaque chambre
        for ($i = 0; $i < 15; $i++) { // 3 hôtels x 5 chambres = 15 chambres
            $reservation = new Reservation();

            // Associer un utilisateur régulier (cycle parmi les 3 utilisateurs)
            $reservation->setUser($regularUsers[$i % 3]);

            // Associer une chambre à la réservation
            $reservation->setRoom($rooms[$i]);

            // Générer une date de début aléatoire (1 à 30 jours à partir de maintenant)
            $startDate = new \DateTimeImmutable("+" . rand(1, 30) . " days");

            // Générer une durée de réservation aléatoire entre 1 et 7 jours
            $duration = rand(1, 7);

            // Définir les dates de début et de fin de la réservation
            $reservation->setStartedAt($startDate);
            $reservation->setEndAt($startDate->add(new \DateInterval("P{$duration}D"))); // Ajouter le nombre de jours à la date de début

            // Date de création
            $reservation->setCreatedAt(new \DateTimeImmutable());

            // Persist la réservation
            $manager->persist($reservation);
        }

        $manager->flush();
    }
}
