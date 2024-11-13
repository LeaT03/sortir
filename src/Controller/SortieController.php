<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    //Fonction refactorisée car code dupliqué dans Create et Edit
    public function enregistrerOuPublier(Sortie $sortie, Request $request,EtatRepository $etatRepository, EntityManagerInterface $em): ?Response {

        $action = $request->get("action");
        $etatCree = $etatRepository->findOneBy(['libelle' => 'Créée']);
        $etatOuvert = $etatRepository->findOneBy(['libelle' => 'Ouverte']);
        $user = $this->getUser();
        //permet de savoir que c'est le user co qui a créé la sortie (organisateur)
        $sortie->setParticipantOrganisateur($user);

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
            $sortie->addParticipantInscrit($user);
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
        if($sortie->getEtat()->getLibelle()==='Ouverte'){
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
        ]);
    }

    #[Route('/details/{id}', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(SortieRepository $sortieRepository, Request $request, int $id): Response{
        $sortie = $sortieRepository->find($id);
        $ville = $sortie->getLieu()->getVille()->getNom();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);


        $inscrits = $sortie->getParticipantInscrits();

        return $this->render('sortie/show.html.twig',[
            'sortieForm' => $sortieForm,
            'sortie' => $sortie,
            'ville' => $ville,
            'inscrits' => $inscrits,
        ]);
    }

    #[Route('{id}/sinscrire', name: 'sinscrire', requirements: ['id'=>'\d+'] , methods: ['GET', 'POST'])]
    public function sinscrire(int $id, SortieRepository $sortieRepository, EntityManagerInterface $em): Response{

        $sortie = $sortieRepository->find($id);
        $participant = $this->getUser();

        if(count($sortie->getParticipantInscrits())>= $sortie->getNbInscriptionMax()){
            $this->addFlash('danger', 'Le nombre de places maximum est atteint.');
            return $this->redirectToRoute('app_main');
        }
        if($sortie->getEtat()->getLibelle()!=='Ouverte') {
            $this->addFlash('danger', 'La sortie doit être ouverte pour s\'inscrire');
            return $this->redirectToRoute('app_main');
        }
        if($sortie->getParticipantInscrits()->contains($participant)){
            $this->addFlash('danger','Vous êtes déjà inscrit à cette sortie.');
            return $this->redirectToRoute('app_main');
        }
        $dateDuJour = new \DateTimeImmutable();
        if($dateDuJour > $sortie->getDateLimiteInscription()){
            $this->addFlash('danger', 'La date limite d\'inscription est dépassée.');
            return $this->redirectToRoute('app_main');
        }

            $sortie->addParticipantInscrit($participant);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Vous êtes bien inscrit à la sortie !');
        return $this->redirectToRoute('app_main');

    }

    #[Route('{id}/delete', name: 'delete', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function delete(Sortie $sortie, EntityManagerInterface $em): Response{

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