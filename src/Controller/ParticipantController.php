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
    #[Route('/participant/monprofil', name: 'app_participant_profil',requirements:['id' => '\d+'], methods: ['GET','POST'])]
    public function index(ParticipantRepository $participantRepository,Request $request, EntityManagerInterface $em): Response
    {
//        Création d'un nouvel objet Participant
//        $participant = new Participant();
        $id = $this->getUser()->getId();
        $participant = $participantRepository->find($id);

        // Création du formulaire pour l'entité Participant
        $participantsForm = $this->createForm(ParticipantType::class, $participant);
        $participantsForm->handleRequest($request);

        // Si le formulaire est soumis et valide, on enregistre le participant
        if ($participantsForm->isSubmitted() && $participantsForm->isValid()) {
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('app_participant_profil');
        }

        // Passage du formulaire au template
        return $this->render('participant/index.html.twig', [
            'participantsForm' => $participantsForm,
            'participant' => $participant,
        ]);

    }

    #[Route('/profil/participant', name: 'app_profil_participant', requirements:['id' => '\d+'], methods: ['GET'])]
    public function participant(ParticipantRepository $participantRepository,Request $request, EntityManagerInterface $em): Response
    {
        $id = $this->getUser()->getId();
        $participant = $participantRepository->find($id);

        $participantsForm = $this->createForm(ParticipantType::class, $participant);
        $participantsForm->handleRequest($request);

        if ($participantsForm->isSubmitted() && $participantsForm->isValid()) {
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('app_profil_participant');
        }
        return $this->render('participant/profil.html.twig', [
            'participantsForm' => $participantsForm,
            'participant' => $participant,
        ]);

    }
}
