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


    public function getLatestWeekends()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date')
            ->where('w.date >= :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult()
            ;
    }

}
