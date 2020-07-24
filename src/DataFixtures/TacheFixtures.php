<?php

namespace App\DataFixtures;

use App\Entity\Tache;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TacheFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $tache = new Tache();
            $tache->setLibelle($faker->sentence('5', true));
            //On gère le fait qu'une tache ne fini pas avant qu'elle commence
            $heure_debut = $faker->dateTimeBetween('now', "2 weeks");
            $tache->setHeureDebut($heure_debut);
            $tache->setHeureFin($faker->dateTimeInInterval("+2 weeks", '+5 days'));
            $tache->setEtat($faker->numberBetween(0,2));
            $manager->persist($tache);
        }

        $manager->flush();
    }
}
