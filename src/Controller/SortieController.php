<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{

    //Fonction refactor code dupliqué dans Create et Edit
    public function enregistrerOuPublier(Sortie $sortie, Request $request,EtatRepository $etatRepository, EntityManagerInterface $em): ?Response {

        $action = $request->get("action");
        $etatCree = $etatRepository->findOneBy(['libelle' => 'Créée']);
        $etatOuvert = $etatRepository->findOneBy(['libelle' => 'Ouverte']);

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if($action === 'enregistrer') {
            $sortie->setEtat($etatCree);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "La sortie a été enregistrée !");
            return $this->redirectToRoute('app_main');
        }

        if($action === 'publier' && $sortieForm->isValid()) {
            $sortie->setEtat($etatOuvert);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "La sortie a été publiée !");
            return $this->redirectToRoute('app_main');
        }
        return null;
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EtatRepository $etatRepository, Request $request, EntityManagerInterface $em): Response
    {
        $sortie = new Sortie();
        $user = $this->getUser();
        //permet de savoir que c'est le user co qui a créé la sortie (organisateur)
        $sortie->setParticipantOrganisateur($user);
        $campus = $user->getCampus();
        $sortie->setCampusOrganisateur($campus);

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if($sortieForm->isSubmitted()){
            $response = $this->enregistrerOuPublier($sortie, $request, $etatRepository, $em );
            if($response){
                return $response;
            }
        }

        return $this->render('sortie/create.html.twig',
            ['sortieForm' => $sortieForm]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function edit (EtatRepository $etatRepository, Sortie $sortie, Request $request,EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $sortie->setParticipantOrganisateur($user);
        $campus = $user->getCampus();
        $sortie->setCampusOrganisateur($campus);

        if($sortie->getParticipantOrganisateur()!==$user){
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à modifier cette sortie.');
        }
        //Si la sortie est déjà ouverte, pas possible de la modif
        if($sortie->getEtat()->getId()===2){
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à modifier cette sortie.');
        }

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if($sortieForm->isSubmitted()) {
            $response = $this->enregistrerOuPublier($sortie, $request, $etatRepository, $em);
            if ($response) {
                return $response;
            }
        }
        return $this->render('sortie/edit.html.twig',[
            'sortieForm' => $sortieForm,
            'sortie' => $sortie,
            'edit_mode'=> true
        ]);
    }

    #[Route('{id}/delete', name: 'delete', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function delete(sortie $sortie, Request $request, EntityManagerInterface $em): Response{

        $user = $this->getUser();

        if($sortie->getParticipantOrganisateur()!==$user){
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette sortie.');
        }
        $user->removeSortieOrganisee($sortie);

        $em->remove($sortie);
        $em->flush();

        $this->addFlash('success', "La sortie a été supprimée.");
        return $this->redirectToRoute('app_main');
    }
}