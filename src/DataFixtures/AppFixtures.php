<?php

/*Ce code représente une classe appelée "AppFixtures" qui est utilisée pour charger des données fictives (fixtures) dans une base de données en utilisant Doctrine dans le cadre d'un projet PHP. */

namespace App\DataFixtures;

use App\Entity\Tache;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <=50 ; $i++) { 
            $tache = new Tache();
            $tache -> setName("N'importe")
            ->setDescription("Ceci est une description")
            ->setStatut("1")
            ->setDateDeFin("02/02/2023");
            
            $manager->persist($tache);
        }



        $manager->flush();
    }
}
