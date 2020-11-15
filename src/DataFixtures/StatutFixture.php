<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Statut;

class StatutFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $libre = new Statut();
        $libre->setLabel('libre');
        $manager->persist($libre);

        $occuper = new Statut();
        $occuper->setLabel('occupé');
        $manager->persist($occuper);

        $nettoyage = new Statut();
        $nettoyage->setLabel('en nettoyage');
        $manager->persist($nettoyage);

        $manager->flush();
    }
}
