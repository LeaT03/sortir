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
        $querybuilder = $this->createQueryBuilder('s');
            if (!empty($criteria['campusOrganisateur'])) {
                $querybuilder->andWhere('s.campusOrganisateur = :campus')
                    ->setParameter('campus', $criteria['campusOrganisateur']);
            }
        $query = $querybuilder->getQuery();
        return $query->getResult();
    }
}
