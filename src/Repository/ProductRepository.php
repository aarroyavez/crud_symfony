<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAvailableProducts($limit, $searchTerm)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.quantity > 0');

        if ($searchTerm) {
            $queryBuilder->andWhere('p.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return $queryBuilder->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
