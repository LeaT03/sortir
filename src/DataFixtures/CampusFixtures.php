<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CampusFixtures extends Fixture implements DependentFixtureInterface
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

    public function getDependencies() :array
    {
        return [ParticipantFixtures::class,SortieFixtures::class];
    }

}
