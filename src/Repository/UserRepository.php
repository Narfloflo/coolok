<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // public function matchSuggest(int $maxLimit)
    // {
    //     $stmt = $this->createQueryBuilder('user');
    //     // $stmt->select(array('flat.city', 'flat.available' ,'count(flat.city) AS length'));
    //     $stmt->where('user.available LIKE :available');
    //     $stmt->add('where', $qb->expr()->orX(
    //         $qb->expr()->eq('u.id', '?1'),
    //         $qb->expr()->like('u.nickname', '?2')
    //     ))
    //     $stmt->groupBy('flat.city');
    //     $stmt->orderBy('count(flat.city)', 'DESC');
    //     $stmt->setMaxResults($maxLimit);
    //     $stmt->setParameter('available', 1);

    //     return $stmt->getQuery()->getResult();
    // }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}