<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Role;
use App\Entity\Statut;
use App\Entity\Tache;
use App\Entity\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SalarieController extends AbstractController
{
    /**
     * @Route("/salarie", name="salarie")
     * @IsGranted("ROLE_MANAGER")
     */
    public function getSalarie(): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);

        $Users = $repo->findBy(['fonction' => 1]);

        foreach($Users as $user){
            
            $taches = $repoTache->findBy([
                'user' => $user,
                'dateFin' => NULL
                ]);
            $user->nbTache = count($taches);
            $UsersFull[] = $user;
            unset($taches);
        }

        return $this->render('salarie/index.html.twig', [
            'controller_name' => 'SalarieController',
            'users' => $UsersFull,
        ]);
    }
}
