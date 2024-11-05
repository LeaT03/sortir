<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $sortie = new Sortie();
        $sortie->setNom('Jardinage');
        $sortie->setDateHeureDebut(new \DateTimeImmutable('2024-11-20'));
        $sortie->setDuree(90);
        $sortie->setDateLimiteInscription(new \DateTimeImmutable('2024-11-15'));
        $sortie->setNbInscriptionMax(8);
        $sortie->setInfosSortie('Venez jardiner chez le potager de la ville (découverte de plusieurs variétés de légumes');
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie->setNom('Karting');
        $sortie->setDateHeureDebut(new \DateTimeImmutable('2024-12-01'));
        $sortie->setDuree(60);
        $sortie->setDateLimiteInscription(new \DateTimeImmutable('2024-11-25'));
        $sortie->setNbInscriptionMax(11);
        $sortie->setInfosSortie('Venez faire une course aux couleurs de Mario');
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie->setNom('painball');
        $sortie->setDateHeureDebut(new \DateTimeImmutable('2024-12-01'));
        $sortie->setDuree(45);
        $sortie->setDateLimiteInscription(new \DateTimeImmutable('2024-11-25'));
        $sortie->setNbInscriptionMax(10);
        $sortie->setInfosSortie('Une partie de painball en pleine forêt');

        $sortie = new Sortie();
        $sortie->setNom('accrobranche');
        $sortie->setDateHeureDebut(new \DateTimeImmutable('2025-01-15'));
        $sortie->setDuree(45);
        $sortie->setDateLimiteInscription(new \DateTimeImmutable('2025-01-05'));
        $sortie->setNbInscriptionMax(10);
        $sortie->setInfosSortie('Plusieurs pistes noires !!! ');


        $manager->flush();
    }
}
