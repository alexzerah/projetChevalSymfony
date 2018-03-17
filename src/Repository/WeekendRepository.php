<?php

namespace App\Repository;

use App\Entity\Weekend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function getTheWeekend($name)
    {
        try {
            return $this->createQueryBuilder('w')
                ->where('w.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

    public function getNextWeekends()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date')
            ->where('w.date >= :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function getPreviousWeekends()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date')
            ->where('w.date < :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function getNextDayWeekends()
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
