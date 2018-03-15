<?php

namespace App\Repository;

use App\Entity\Weekend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Weekend|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weekend|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weekend[]    findAll()
 * @method Weekend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekendRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Weekend::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('w')
            ->where('w.something = :value')->setParameter('value', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
