<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $lieu1 = new Lieu();
        $lieu1->setNom('Parc du Tabor');
        $lieu1->setRue('PI Saint-Mélaine');
        $lieu1->setLatitude('48.6');
        $lieu1->setLongitude('5.02');
        $lieu1->setVille($this->getReference('ville '.mt_rand(1,4)));
        $this->addReference('lieu 1', $lieu1);
        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('Musée des Beaux-Arts');
        $lieu2->setRue('20 Quai Emile Zola');
        $lieu2->setLatitude('48.6');
        $lieu2->setLongitude('5.02');
        $lieu2->setVille($this->getReference('ville '.mt_rand(1,4)));
        $this->addReference('lieu 2', $lieu2);
        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom('Opéra de Quimper');
        $lieu3->setRue('PI de la Mairie');
        $lieu3->setLatitude('48.6');
        $lieu3->setLongitude('5.02');
        $lieu3->setVille($this->getReference('ville '.mt_rand(1,4)));
        $this->addReference('lieu 3', $lieu3);
        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNom('Opéra de Niort');
        $lieu4->setRue('PI de la Mairie');
        $lieu4->setLatitude('48.6');
        $lieu4->setLongitude('5.02');
        $lieu4->setVille($this->getReference('ville '.mt_rand(1,4)));
        $this->addReference('lieu 4', $lieu4);
        $manager->persist($lieu4);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return[VilleFixtures::class];
    }
}
