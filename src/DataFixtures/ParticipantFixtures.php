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

        //Initialisation de Faker
        $faker = \Faker\Factory::create('fr_FR');

        //Créer un administrateur
        $participantAdmin = new Participant();
        $participantAdmin->setPseudo('admin');
        $participantAdmin->setNom('adminNom');
        $participantAdmin->setPrenom('adminPrenom');
        $participantAdmin->setTelephone('00.00.00.00.00');
        $participantAdmin->setEmail('admin@test.fr');
        $participantAdmin->setActif('1');
        $participantAdmin->setRoles(['ROLE_ADMIN']);
        $password=$this->userPasswordHasher->hashPassword($participantAdmin,'123456');
        $participantAdmin->setPassword($password);
        $manager->persist($participantAdmin);

        //Créer 10 Participants
        for ($i = 0; $i < 10; $i++) {
            $participant = new Participant();
            $participant ->setPseudo($faker->userName);
            $participant->setNom($faker->lastName);
            $participant->setPrenom($faker->firstName);
            $participant->setTelephone($faker->phoneNumber);
            $participant->setEmail($faker->email);
            $participant->setActif(1);
            $participant->setRoles(['ROLE_USER']);
            $password=$this->userPasswordHasher->hashPassword($participantAdmin,'123456');
            $participant->setPassword($password);
            $manager->persist($participant);
        }

        $manager->flush();
    }
}
