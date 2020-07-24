<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Tache;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Tache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tache[]    findAll()
 * @method Tache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tache::class);
    }

    /**
     * Permet d'avoir le nombre de tâche en fonction d'un état
     *
     * @param integer $etat
     * @return array['nb']
     */
    public function getNbTacheByEtat(int $etat){
        $query = $this->createQueryBuilder('tache')
        ->select('count(tache.id) as nb')
        ->where("tache.etat = :etat")
        ->setParameter('etat', $etat);
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Permet d'avoir les tâches les plus imminentes et non prise par un employé
     *
     * @return Tache[]
     */
    public function getTacheNonPrise(){
        $query = $this->createQueryBuilder('tache')
        ->where("tache.etat = 0")
        ->orderBy('tache.heureDebut', "ASC");

        return $query->getQuery()->getResult();
    }

    /**
     * Récupère la tâche en cours d'un employé
     *
     * @param User $user
     * @return Tache|null
     */
    public function getTacheActuelle(User $user){
        $query = $this->createQueryBuilder('tache')
        ->join('tache.liaisonTacheUser', 'liaison')
        ->join('liaison.user', 'user')
        ->where("tache.etat = 1")
        ->andWhere('liaison.user = :user')
        ->setParameter('user', $user);

        return $query->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return Tache[] Returns an array of Tache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tache
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
