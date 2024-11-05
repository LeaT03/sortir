<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création 4 campus
        $campus = new Campus();
        $campus->setNom("Nantes");
        $manager->persist($campus);

        $campus = new Campus();
        $campus->setNom("Rennes");
        $manager->persist($campus);

        $campus = new Campus();
        $campus->setNom("Quimper");
        $manager->persist($campus);

        $campus = new Campus();
        $campus->setNom("Niort");
        $manager->persist($campus);

        $manager->flush();
    }
}
