<?php

namespace App\DataFixtures;

use App\Entity\BiensImmobilier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $immo_fixtures = new BiensImmobilier();
            $immo_fixtures->setType('maison '.$i);
            $immo_fixtures->setSurface(mt_rand(10, 100));
            $immo_fixtures->setPrix(mt_rand(100000, 1000000));
            $immo_fixtures->setLocalisation("Paris");
            $immo_fixtures->setDateDeCreation(new \Datetime());
            $manager->persist($immo_fixtures);
        }

        $manager->flush();
    }
}
