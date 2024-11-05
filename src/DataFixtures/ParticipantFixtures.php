<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher){

    }
    public function load(ObjectManager $manager): void
    {
        //Créer un administrateur
        $participantAdmin = new Participant();
        $participantAdmin->setPseudo('admin@test.fr');
        $participantAdmin->setNom('admin');
        $participantAdmin->setPrenom('admin@test.fr');
        $participantAdmin->setTelephone('admin@test.fr');
        $participantAdmin->setEmail('admin@test.fr');
        $participantAdmin->setPassword('admin@test.fr');
        $participantAdmin->setActif('admin@test.fr');
        $participantAdmin->setRoles(['ROLE_ADMIN']);
        $password=$this->userPasswordHasher->hashPassword($participantAdmin,'123456');
        $participantAdmin->setPassword($password);
        $manager->persist($participantAdmin);

        //Créer 10 Utilisateurs
        for ($i = 0; $i < 10; $i++) {
            $user = new Participant();
            $user->setNom("user$i");
            $user->setPrenom("user$i@test.fr");
            $user->setRoles(['ROLE_USER']);
            $password=$this->userPasswordHasher->hashPassword($participantAdmin,'123456');
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
