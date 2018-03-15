<?php

namespace App\Repository;

use App\Entity\Soiree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Soiree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Soiree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Soiree[]    findAll()
 * @method Soiree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoireeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Soiree::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
