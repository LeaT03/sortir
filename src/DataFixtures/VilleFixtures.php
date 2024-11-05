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

        $Ville = new Ville();
        $Ville->setNom('Nantes');
        $Ville->setCodePostal('44000');

        $Ville = new Ville();
        $Ville->setNom('Rennes');
        $Ville->setCodePostal('35000');

        $Ville = new Ville();
        $Ville->setNom('Niort');
        $Ville->setCodePostal('79000');


        $manager->flush();
    }
}
