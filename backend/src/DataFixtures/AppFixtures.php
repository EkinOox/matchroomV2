<?php

namespace App\DataFixtures;

use App\Entity\RoulettePrize;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Tableau des montants des gains avec leurs probabilités
        // $prizesData = [
        //     ['amount' => 50, 'probability' => 0.30],
        //     ['amount' => 100, 'probability' => 0.25],
        //     ['amount' => 150, 'probability' => 0.20],
        //     ['amount' => 200, 'probability' => 0.10],
        //     ['amount' => 250, 'probability' => 0.10],
        //     ['amount' => 300, 'probability' => 0.05],
        // ];

        // foreach ($prizesData as $data) {
        //     $prize = new RoulettePrize();
        //     $prize->setAmount($data['amount']);
        //     $prize->setProbability($data['probability']);
        //     $manager->persist($prize);
        // }

        $manager->flush();
    }
}
