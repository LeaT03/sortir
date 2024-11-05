<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Ville = new Ville();
        $Ville->setNom('Quimper');
        $Ville->setCodePostal('29000');
        $this->addReference('ville 1', $Ville);
        $manager->persist($Ville);

        $Ville2 = new Ville();
        $Ville2->setNom('Nantes');
        $Ville2->setCodePostal('44000');
        $this->addReference('ville 2', $Ville2);
        $manager->persist($Ville2);

        $Ville3 = new Ville();
        $Ville3->setNom('Rennes');
        $Ville3->setCodePostal('35000');
        $this->addReference('ville 3', $Ville3);
        $manager->persist($Ville3);

        $Ville4 = new Ville();
        $Ville4->setNom('Niort');
        $Ville4->setCodePostal('79000');
        $this->addReference('ville 4', $Ville4);
        $manager->persist($Ville4);


        $manager->flush();
    }
}
