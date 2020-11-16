<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Statut;
use App\Entity\Tache;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre_index")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

        $chambres = $repo->findAll();


        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'role_user' => 'manager',
            'chambres' => $chambres
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

        /**
     * @Route("/chambre/edit/statut/{id_chambre}/{id_statut}", name="edit_statut_chambre")
     */
    public function editChambreStatut($id_chambre, $id_statut){
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Chambre::class);
        $repo2 = $entityManager->getRepository(Statut::class);
        $statut = $repo2->find($id_statut);

        $chambre = $repo->find($id_chambre);
        $chambre->setStatut($statut);

        $entityManager->flush();

        return $this->redirectToRoute('chambre_index');
    }
}
  