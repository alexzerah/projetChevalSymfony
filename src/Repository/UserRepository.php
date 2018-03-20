<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername($username)
    {
        try {
            return $this->createQueryBuilder('u')
                ->where('u.username = :username OR u.email = :email')
                ->setParameter('username', $username)
                ->setParameter('email', $username)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

    public function getTeamMembers()
    {
        return $this->createQueryBuilder('u')
            ->where('u.isAdmin = :role')
            ->setParameter('role', '1')
            ->getQuery()
            ->getResult();
    }

    // Work in progress (try to get user follows)

    public function getUserFollow()
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.exhibitFollow', 'e')
            ->where('e.id = :eid AND u.id = :uid')
            ->setParameter('eid', '10')
            ->setParameter('uid', '1')
            ->getQuery()
            ->getResult();
    }
}
