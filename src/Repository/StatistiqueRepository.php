<?php

namespace App\Repository;

use App\Entity\Statistique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Statistique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statistique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statistique[]    findAll()
 * @method Statistique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatistiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistique::class);
    }

    // Tu peux ajouter ici des requêtes personnalisées si besoin
}
