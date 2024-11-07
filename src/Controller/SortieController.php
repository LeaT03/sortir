<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EtatRepository $etatRepository, Request $request, EntityManagerInterface $em): Response
    {
        $sortie = new Sortie();
        //permet de savoir que c'est le user co qui a créé la sortie (organisateur)
        $sortie->setParticipantOrganisateur($this->getUser());
        $participant = $this->getUser();
        $campus = $participant->getCampus();
        $sortie->setParticipantOrganisateur($participant);
        $sortie->setCampusOrganisateur($campus);

        $etatCree = $etatRepository->findOneBy(['libelle' => 'Créée']);
        $etatOuvert = $etatRepository->findOneBy(['libelle' => 'Ouverte']);

        $sortieForm = $this->createForm(SortieType::class, $sortie);

$sortieForm->handleRequest($request);

        if($sortieForm->isSubmitted()){
            $action = $request->get("action");

            if($action === 'enregistrer') {
                $sortie->setEtat($etatCree);
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('sucess', 'La sortie a été enregistrée !');
                return $this->redirectToRoute('app_main');
            }

            if($action === 'publier' && $sortieForm->isValid()) {
                $sortie->setEtat($etatOuvert);
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('sucess', 'La sortie a été publiée !');
                return $this->redirectToRoute('app_main');
            }
        }

        return $this->render('sortie/create.html.twig',
            ['sortieForm' => $sortieForm]);
    }
}