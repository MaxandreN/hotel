<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $Employedechambre = new Role();
        $Employedechambre->setLabel('Employé de chambre');
        $manager->persist($Employedechambre);

        $Receptionniste  = new Role();
        $Receptionniste ->setLabel('Réceptionniste ');
        $manager->persist($Receptionniste);

        $manageur  = new Role();
        $manageur ->setLabel('manager ');
        $manager->persist($manageur);
         

        $manager->flush();
    }
}
