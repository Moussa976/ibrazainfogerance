<?php

namespace App\Repository;

use App\Entity\ReseauSocial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReseauSocial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReseauSocial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReseauSocial[]    findAll()
 * @method ReseauSocial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReseauSocialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReseauSocial::class);
    }

    // Tu peux ajouter ici des requêtes personnalisées si besoin
}
