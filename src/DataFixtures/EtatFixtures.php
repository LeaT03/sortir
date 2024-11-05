<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $etat1 = new Etat();
        $etat1->setLibelle('Créée');
        $this->addReference('etat 1', $etat1);
        $manager->persist($etat1);

        $etat2 = new Etat();
        $etat2->setLibelle('Ouverte');
        $this->addReference('etat 2', $etat2);
        $manager->persist($etat2);

        $etat3 = new Etat();
        $etat3->setLibelle('Clôturée');
        $this->addReference('etat 3', $etat3);
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle('Activité en cours');
        $this->addReference('etat 4', $etat4);
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle('Passée');
        $this->addReference('etat 5', $etat5);
        $manager->persist($etat5);

        $etat6 = new Etat();
        $etat6->setLibelle('Annulée');
        $this->addReference('etat 6', $etat6);
        $manager->persist($etat6);


        $manager->flush();
    }
}
