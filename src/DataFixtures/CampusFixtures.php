<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création 4 campus
        $campus1 = new Campus();
        $campus1->setNom("Nantes");
        $this->addReference('campus 1', $campus1);
        $manager->persist($campus1);

        $campus2 = new Campus();
        $campus2->setNom("Rennes");
        $this->addReference('campus 2', $campus2);
        $manager->persist($campus2);

        $campus3 = new Campus();
        $campus3->setNom("Quimper");
        $this->addReference('campus 3', $campus3);
        $manager->persist($campus3);

        $campus4 = new Campus();
        $campus4->setNom("Niort");
        $this->addReference('campus 4', $campus4);
        $manager->persist($campus4);

        $manager->flush();
    }

}
