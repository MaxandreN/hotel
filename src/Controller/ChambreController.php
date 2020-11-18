<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Statut;
use App\Entity\Tache;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre/RECE", name="chambre_index_RECE")
     * @IsGranted("ROLE_RECEPTIONNISTE")
     */
    public function indexRECE(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

        $chambres = $repo->findAll();


        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'chambres' => $chambres
        ]);

    }

    /**
     * @Route("/chambre/MANA", name="chambre_index_MANA")
     * @IsGranted("ROLE_MANAGER")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

        $chambres = $repo->findAll();


        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'chambres' => $chambres
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

        return $this->redirectToRoute('chambre_index_RECE');
    }
}
  