<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findByCriteria(array $criteria)
    {
        $querybuilder = $this->createQueryBuilder('s')

            ->leftJoin('s.participantInscrits', 'p')
            ->addSelect('p');

            if (!empty($criteria['campusOrganisateur'])) {
                $querybuilder->andWhere('s.campusOrganisateur = :campus')
                    ->setParameter('campus', $criteria['campusOrganisateur']);
            }
        if (!empty($criteria['nom'])) {
            $querybuilder->andWhere('s.nom LIKE :nom')
                ->setParameter('nom', '%' . $criteria['nom'] . '%');
        }
        if(!empty($criteria['dateEntre'])) {
            $querybuilder->andWhere('s.dateHeureDebut >= :dateHeureDebutEntre')
                ->setParameter('dateHeureDebutEntre', $criteria['dateEntre']);
        }
        if(!empty($criteria['dateFin'])) {
            $querybuilder->andWhere('s.dateHeureDebut <= :dateHeureDebutFin')
                ->setParameter('dateHeureDebutFin', $criteria['dateFin']);
        }
        if(!empty($criteria['sortieOrganisateur'])) {
            $querybuilder->andWhere('s.participantOrganisateur = :participantOrganisateur')
                ->setParameter('participantOrganisateur', $criteria['sortieOrganisateur']);
        }
        if(!empty($criteria['sortieInscrit'])) {
            $querybuilder->andWhere('p.id = :participantInscrits')
                ->setParameter('participantInscrits', $criteria['sortieInscrit']);
        }
        if(!empty($criteria['sortieNonInscrit'])) {
            $querybuilder->andWhere('p.id != :participantInscrits or s.participantInscrits != :participantInscrits' )
                ->setParameter('participantInscrits', $criteria['sortieNonInscrit']);
        }
        if (!empty($criteria['sortiePassee'])) {
            $querybuilder->andWhere('s.dateLimiteInscription < :now')
                ->setParameter('now', new \DateTime());
        }
//        if(!empty($criteria['sortieOrganisateur'])) {       !!!!!! Verifier si tris les inscrit
//            $querybuilder->andWhere('s.id = :id ')
//                ->setParameter('id', $criteria['sortieOrganisateur']);
//        }
        $query = $querybuilder->getQuery();
        return $query->getResult();
    }


}
