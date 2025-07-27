<?php

namespace App\Repository;

use App\Entity\PageContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageContent[]    findAll()
 * @method PageContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageContent::class);
    }

    // Tu peux ajouter ici des requêtes personnalisées si besoin
}
