<?php

namespace App\Repository;

use App\Entity\Exhibit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Exhibit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exhibit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exhibit[]    findAll()
 * @method Exhibit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExhibitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Exhibit::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('e')
            ->where('e.something = :value')->setParameter('value', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
