<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $lieu = new Lieu();
        $lieu->setNom('Parc du Tabor');
        $lieu->setRue('PI Saint-Mélaine');
        $lieu->setLatitude('48°,06,51 N');
        $lieu->setLongitude('1°,40,12 O');
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu->setNom('Musée des Beaux-Arts');
        $lieu->setRue('20 Quai Emile Zola');
        $lieu->setLatitude('47°,19,10,56 N');
        $lieu->setLongitude('5°,02,20,16 E');
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu->setNom('Opéra de Quimper');
        $lieu->setRue('PI de la Mairie');
        $lieu->setLatitude('48°,6,40,11 N');
        $lieu->setLongitude('1°,40,43,6 O');
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu->setNom('Opéra de Niort');
        $lieu->setRue('PI de la Mairie');
        $lieu->setLatitude('48°,6,50,11 N');
        $lieu->setLongitude('1°,10,43,6 O');
        $manager->persist($lieu);

        $manager->flush();
    }
}
