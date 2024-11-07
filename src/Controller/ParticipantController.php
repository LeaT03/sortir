<?php

// src/Controller/ParticipantController.php
namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/participant/{id}', name: 'app_participant_profil',requirements:['id' => '\d+'], methods: ['GET'])]
    public function index(ParticipantRepository $participantRepository,Request $request, EntityManagerInterface $em, int $id): Response
    {
//        Création d'un nouvel objet Participant
//        $participant = new Participant();

        $participant = $participantRepository->find($id);

        // Création du formulaire pour l'entité Participant
        $participantsForm = $this->createForm(ParticipantType::class, $participant);
        $participantsForm->handleRequest($request);

        // Si le formulaire est soumis et valide, on enregistre le participant
//        if ($participantsForm->isSubmitted() && $participantsForm->isValid()) {
//            $em->persist($participant);
//            $em->flush();
//        }

        // Passage du formulaire au template
        return $this->render('participant/index.html.twig', [
            'participantsForm' => $participantsForm,
            'participant' => $participant,
        ]);

    }
}
