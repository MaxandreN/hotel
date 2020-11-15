<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chambre;
use App\Entity\Statut;

class ChambreFixture extends Fixture
{
    private $Satuts;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->Satuts = $em->getRepository(Statut::class);
    }

    public function load(ObjectManager $manager)
    {

        $stats = $this->Satuts->findAll();
        $stat = $stats[0];

        for($i = 1; $i <= 3; $i++){
            $chambre = new Chambre();
            $chambre->setEtage(1)
            ->setNumero($i)
            ->setStatut($stat);

            $manager->persist($chambre);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            StatutFixture::class,
        );
    }
}
