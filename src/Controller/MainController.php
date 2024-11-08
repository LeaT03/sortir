<?php

namespace App\Controller;

use App\Form\Models\Search;
use App\Form\SearchType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/Accueil', name: 'app_main', methods: ['GET','POST'])]
    public function list(SortieRepository $sortieRepository, Request $request): Response
    {
        $sorties = $sortieRepository->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $criteria =[]; //Récupère form sous tableau
            if ($search->getCampusOrganisateur()){
                $criteria['campusOrganisateur'] = $search->getCampusOrganisateur();
            }
            $sorties = $sortieRepository->findByCriteria($criteria);
        }

            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'sorties' => $sorties,
                'form' => $form
            ]);
        }
    }



