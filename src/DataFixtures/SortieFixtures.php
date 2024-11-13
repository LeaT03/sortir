<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Création de 4 sorties
        $sortie1 = new Sortie();
        $sortie1->setNom('Jardinage');
        $sortie1->setDateHeureDebut(new \DateTimeImmutable('2024-11-20'));
        $sortie1->setDuree(90);
        $sortie1->setDateLimiteInscription(new \DateTimeImmutable('2024-11-15'));
        $sortie1->setNbInscriptionMax(8);
        $sortie1->setInfosSortie('Venez jardiner chez le potager de la ville (découverte de plusieurs variétés de légumes');
        $sortie1->setCampusOrganisateur($this->getReference('campus '.mt_rand(1,4)));
        $sortie1->setEtat($this->getReference('etat '.mt_rand(1,2)));
        $sortie1->setParticipantOrganisateur($this->getReference('participant '.mt_rand(0,9)));
        $sortie1->setLieu($this->getReference('lieu 1'));
        $this->addReference('sortie 1', $sortie1);
        $manager->persist($sortie1);

        $sortie2 = new Sortie();
        $sortie2->setNom('Karting');
        $sortie2->setDateHeureDebut(new \DateTimeImmutable('2024-12-01'));
        $sortie2->setDuree(60);
        $sortie2->setDateLimiteInscription(new \DateTimeImmutable('2024-11-25'));
        $sortie2->setNbInscriptionMax(11);
        $sortie2->setInfosSortie('Venez faire une course aux couleurs de Mario');
        $sortie2->setCampusOrganisateur($this->getReference('campus '.mt_rand(1,4)));
        $sortie2->setEtat($this->getReference('etat '.mt_rand(1,2)));
        $sortie2->setParticipantOrganisateur($this->getReference('participant '.mt_rand(0,9)));
        $sortie2->setLieu($this->getReference('lieu 2'));
        $this->addReference('sortie 2', $sortie2);
        $manager->persist($sortie2);

        $sortie3 = new Sortie();
        $sortie3->setNom('Paintball');
        $sortie3->setDateHeureDebut(new \DateTimeImmutable('2024-12-01'));
        $sortie3->setDuree(45);
        $sortie3->setDateLimiteInscription(new \DateTimeImmutable('2024-11-25'));
        $sortie3->setNbInscriptionMax(10);
        $sortie3->setInfosSortie('Une partie de paintball en pleine forêt');
        $sortie3->setCampusOrganisateur($this->getReference('campus '.mt_rand(1,4)));
        $sortie3->setEtat($this->getReference('etat '.mt_rand(1,2)));
        $sortie3->setParticipantOrganisateur($this->getReference('participant '.mt_rand(0,9)));
        $sortie3->setLieu($this->getReference('lieu 3'));
        $this->addReference('sortie 3', $sortie3);
        $manager->persist($sortie3);

        $sortie4 = new Sortie();
        $sortie4->setNom('Accrobranche');
        $sortie4->setDateHeureDebut(new \DateTimeImmutable('2025-01-15'));
        $sortie4->setDuree(45);
        $sortie4->setDateLimiteInscription(new \DateTimeImmutable('2025-01-05'));
        $sortie4->setNbInscriptionMax(10);
        $sortie4->setInfosSortie('Plusieurs pistes noires !!! ');
        $sortie4->setCampusOrganisateur($this->getReference('campus '.mt_rand(1,4)));
        $sortie4->setEtat($this->getReference('etat '.mt_rand(1,2)));
        $sortie4->setParticipantOrganisateur($this->getReference('participant '.mt_rand(0,9)));
        $sortie4->setLieu($this->getReference('lieu 4'));
        $this->addReference('sortie 4', $sortie4);
        $manager->persist($sortie4);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [LieuFixtures::class, ParticipantFixtures::class, EtatFixtures::class, CampusFixtures::class];
    }
}
