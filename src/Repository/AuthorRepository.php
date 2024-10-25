<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
       public function findByName($value): array
        {
            return $this->createQueryBuilder('a')
               ->andWhere('a.email = :val')
                ->setParameter('val', $value)
                ->orderBy('a.email', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findByNameDQL($value){
            $em = $this->getEntityManager(); 
            $query= $em->createQuery('SELECT a FROM App\Entity\Author a 
            WHERE a.username = :val ORDER BY a.username ASC');     
            $query->setParameter('val', $value);  
            $results = $query->getResult();    
             return $results;    
   

        }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
