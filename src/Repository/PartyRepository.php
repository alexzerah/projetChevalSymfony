<?php

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Party::class);
    }

    public function getLatestParties()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date')
            ->where('w.date >= :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult()
            ;
    }

    public function getOldParties()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.date')
            ->where('w.date < :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult()
            ;
    }
    public function getNextDayParties()
    {
        $nextDayStart =  new \DateTime();
        $nextDayStart->modify('+ 1 day')->setTime(0,0,1);

        $nextDayEnd =  new \DateTime();
        $nextDayEnd->modify('+ 1 day')->setTime(23,59,59);

        return $this->createQueryBuilder('p')
            ->andWhere('p.date BETWEEN :nextDayStart AND :nextDayEnd')
            ->setParameter('nextDayStart', $nextDayStart)
            ->setParameter('nextDayEnd', $nextDayEnd)
            ->getQuery()
            ->getResult()
            ;
    }
}
