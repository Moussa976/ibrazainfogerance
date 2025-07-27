<?php

namespace App\Repository;

use App\Entity\Coordonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coordonnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coordonnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coordonnee[]    findAll()
 * @method Coordonnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoordonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coordonnee::class);
    }

    // Tu peux ajouter ici des requêtes personnalisées si besoin
}
