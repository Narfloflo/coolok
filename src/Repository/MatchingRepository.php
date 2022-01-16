<?php

namespace App\Repository;

use App\Entity\Matching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Matching|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matching|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matching[]    findAll()
 * @method Matching[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matching::class);
    }

    public function listFirstMatch($currentUser)
    {
        $stmt = $this->createQueryBuilder('matching');
        $stmt->where('matching.userA = :val');
        $stmt->andWhere('matching.matchingA_at IS NOT NULL');
        $stmt->andWhere('matching.matchingB_at IS NULL');
        $stmt->setParameter('val', $currentUser);

        return $stmt->getQuery()->getResult();
    }

    public function alreadyMatch($currentUser)
    {
        $stmt = $this->createQueryBuilder('matching');
        $stmt->where('matching.userB = :val');
        $stmt->andWhere('matching.matchingB_at IS NULL');
        $stmt->setParameter('val', $currentUser);

        return $stmt->getQuery()->getResult();
    }

    public function notToDisplay($currentUser)
    {
        $stmt = $this->createQueryBuilder('matching');
        $stmt->where('matching.userB = :val');
        $stmt->andWhere('matching.matchingB_at IS NOT NULL');
        $stmt->andWhere('matching.fullMatchingAt IS  NULL');
        $stmt->setParameter('val', $currentUser);

        return $stmt->getQuery()->getResult();
    }

    public function findMyFullMatch($currentUser)
    {
        $stmt = $this->createQueryBuilder('matching');
        $stmt->where('matching.userA = :val');
        $stmt->orWhere('matching.userB = :val');
        $stmt->andWhere('matching.fullMatchingAt IS NOT NULL');
        $stmt->setParameter('val', $currentUser);

        return $stmt->getQuery()->getResult();
    }
    // /**
    //  * @return Matching[] Returns an array of Matching objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Matching
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
