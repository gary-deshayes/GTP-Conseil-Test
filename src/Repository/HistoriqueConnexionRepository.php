<?php

namespace App\Repository;

use App\Entity\HistoriqueConnexion;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoriqueConnexion|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueConnexion|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueConnexion[]    findAll()
 * @method HistoriqueConnexion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueConnexionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriqueConnexion::class);
    }

    /**
     * Permet de savoir combien d'heures un employé a travaillé dans la journée
     *
     * @param User $user
     * @return array['ecart_seconde']
     */
    public function getEmployeNombreHeureTravailJournee(User $user){
        date_default_timezone_set('Europe/Paris');
        $now = new \DateTime();
        $query = $this->createQueryBuilder('historique')
        ->select('TIMESTAMPDIFF(SECOND, MIN(historique.dateConnexion), :now) as ecart_seconde')
        ->where('historique.user = :user')
        ->andWhere('DATE(historique.dateConnexion) = :now_date')
        ->setParameter('user', $user)
        ->setParameter('now', $now)
        ->setParameter('now_date', $now->format('Ymd'));

        return $query->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return HistoriqueConnexion[] Returns an array of HistoriqueConnexion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoriqueConnexion
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
