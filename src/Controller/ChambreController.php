<?php

namespace App\Controller;

use App\Entity\Chambre;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

        $chambres = $repo->findAll();

        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'role_user' => 'manager',
            // 'chambres' => $chambres
        ]);

    }

    /**
     * @Route("/chambre/edit", name="edit_chambre")
     */
    public function editChambre(){
        return $this->render('chambre/edit.html.twig', [
            'controller_name' => 'ChambreController',
            'role_user' => 'manager'
        ]);
    }
}
  