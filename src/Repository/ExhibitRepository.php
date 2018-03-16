<?php

namespace App\Repository;

use App\Entity\Exhibit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function getTheExhibit($name)
    {
        try {
            return $this->createQueryBuilder('e')
                ->where('e.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

    public function getNextExhibits()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date')
            ->where('e.date >= :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function getPreviousExhibits()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date')
            ->where('e.date < :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function getNextDayExhibits()
    {
        $nextDayStart =  new \DateTime();
        $nextDayStart->modify('+ 1 day')->setTime(0,0,1);

        $nextDayEnd =  new \DateTime();
        $nextDayEnd->modify('+ 1 day')->setTime(23,59,59);

        return $this->createQueryBuilder('e')
            ->andWhere('e.date BETWEEN :nextDayStart AND :nextDayEnd')
            ->setParameter('nextDayStart', $nextDayStart)
            ->setParameter('nextDayEnd', $nextDayEnd)
            ->getQuery()
            ->getResult()
            ;
    }
}
