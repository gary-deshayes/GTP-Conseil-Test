<?php

namespace App\Repository;

use App\Entity\Search\UserSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Permet de faire des recherches sur les différents champs d'un utilisateur
     *
     * @param UserSearch $search
     * @return User[] Tableau d'utilisateurs trouvés
     */
    public function searchUser(UserSearch $search){
        $query = $this->createQueryBuilder('user');
        $query->orderBy('user.nom', "ASC");
        if ($search->getNom() != null) {
            $query->orWhere('user.nom LIKE :nom')
                ->setParameter('nom', "%" . $search->getNom() . "%");
        }
        if ($search->getPrenom() != null) {
            $query->orWhere('user.prenom LIKE :prenom')
                ->setParameter('prenom', "%" . $search->getPrenom() . "%");
        }
        if ($search->getRoles() != null) {
            $query->orWhere('user.roles LIKE :roles')
                ->setParameter('roles', "%" . $search->getRoles() . "%");
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Permet de savoir combien d'employés sont inscrits
     *
     * @return array['nb']
     */
    public function nbEmployee(){
        $query = $this->createQueryBuilder('user')
        ->select("count(user.id) as nb")->where('user.roles LIKE :roles')
        ->setParameter('roles', "%ROLE_EMPLOYE%");
        return $query->getQuery()->getOneOrNullResult();
    }

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
