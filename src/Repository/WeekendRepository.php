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


    public function getLatestEvents()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getNextDayEvents()
    {
        $nextDayStart =  new \DateTime();
        $nextDayStart->modify('+ 1 day')->setTime(0,0,1);

        $nextDayEnd =  new \DateTime();
        $nextDayEnd->modify('+ 1 day')->setTime(23,59,59);

        return $this->createQueryBuilder('w')
            ->andWhere('w.date BETWEEN :nextDayStart AND :nextDayEnd')
            ->setParameter('nextDayStart', $nextDayStart)
            ->setParameter('nextDayEnd', $nextDayEnd)
            ->getQuery()
            ->getResult()
        ;
    }
}
