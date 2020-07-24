<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Permet de générer 15 comptes d'employés et un compte d'administrateur
 */
class UserFixtures extends Fixture
{
    /**
     * Permet d'encoder les mots de passes dans l'algorithme choisi pour l'utilisateur
     *
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoder = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        //Employé
        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setNom($faker->lastName)
                ->setPrenom($faker->lastName)
                ->setEmail($faker->safeEmail)
                ->setRoles(['ROLE_EMPLOYE'])
                ->setPassword($this->userPasswordEncoder->encodePassword($user, 'azerty'));
                if($i == 0){
                    $user->setEmail('gtp@employe.fr');
                }
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setNom("GTP")
            ->setPrenom("Admin")
            ->setEmail("gtp@admin.fr")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->userPasswordEncoder->encodePassword($admin, 'azerty'));
        $manager->persist($admin);

        $manager->flush();
    }
}
