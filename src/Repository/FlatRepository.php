<?php

namespace App\Repository;

use App\Entity\Flat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Flat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flat[]    findAll()
 * @method Flat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flat::class);
    }

    // /**
    //  * Return cities with the most flat
    //  */
    public function flatBiggestCity(int $maxLimit)
    {
        $stmt = $this->createQueryBuilder('flat');
        $stmt->select(array('flat.city', 'flat.available' ,'count(flat.city) AS length'));
        $stmt->where('flat.available LIKE :available');
        $stmt->groupBy('flat.city');
        $stmt->orderBy('count(flat.city)', 'DESC');
        $stmt->setMaxResults($maxLimit);
        $stmt->setParameter('available', 1);

        return $stmt->getQuery()->getResult();
    }

    public function search(string $q, $option = null)
    {
        $stmt = $this->createQueryBuilder('e');


            $stmt->where('e.city LIKE :query');
            $stmt->orWhere('e.furnished LIKE :query');
            $stmt->orWhere('e.gender LIKE :query');
            $stmt->orWhere('e.description LIKE :query');


            switch ($option)
            {
                case 'furnished':
                    $stmt->orWhere('e.furnished LIKE :query');
                    break;

                case 'space':
                    $stmt->orWhere('e.free_space LIKE :query');
                    break;

                    case 'surface':
                        $stmt->orWhere('e.surface LIKE :query');
                        break;    

                case 'rent':
                    $stmt->orWhere('e.rent LIKE :query');
                    break;

                case 'gender':
                    $stmt->orWhere('e.gender LIKE :query');
                    break;
    
                
                default:

            }

            $stmt->setParameter(':query', '%' . $q . '%');
        
        
        return $stmt->getQuery()->getResult();

        if(!empty($criteria['flat'])){
            $stmt->andWhere('e.flat = :flat');
            $stmt->setParameter('flat', $criteria['flat']);
        }

        }        
    }


    // public function searchFurnished(string $q)
    // {
    //     if(!empty($criteria['query'])){
    //         $stmt->leftJoin('e.place', 'p');

    //         $stmt->where('e.city LIKE :query');
    //         $stmt->orWhere('e.description LIKE :query');
    //         $stmt->orWhere('p.name LIKE :query');
    //         $stmt->setParameter('query', '%' . $criteria['query'] . '%');
    //     }

    //     if(!empty($criteria['furnished'])){
    //         $stmt->andWhere('e.furnished = :furnished');
    //         $stmt->setParameter('furnished', $criteria['furnished']);
    //     }
    // }
    
    // /**
    //  * @return Flat[] Returns an array of Flat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Flat
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
