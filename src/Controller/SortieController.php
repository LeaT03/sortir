<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $sortie = new Sortie();
        //permet de savoir que c'est le user co qui a créé la sortie (organisateur)
        $sortie->setParticipantOrganisateur($this->getUser());
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('sucess', 'La sortie a bien été ajoutée !');
            //TODO changer redirect > rediriger sur page accueil ou détail de la sortie ?
            return $this->redirectToRoute('sortie_create');
        }

        return $this->render('sortie/create.html.twig',
            ['sortieForm' => $sortieForm]);
    }
}
