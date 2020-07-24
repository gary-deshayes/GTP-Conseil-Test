<?php

namespace App\Repository;

use App\Entity\LiaisonTacheUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LiaisonTacheUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LiaisonTacheUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LiaisonTacheUser[]    findAll()
 * @method LiaisonTacheUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiaisonTacheUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LiaisonTacheUser::class);
    }

    // /**
    //  * @return LiaisonTacheUser[] Returns an array of LiaisonTacheUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LiaisonTacheUser
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
