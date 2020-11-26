<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Statut;
use App\Entity\Tache;
use App\Form\ChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class ChambreController extends AbstractController
{

    /**
     * @Route("/chambre/delete/{id}", name="delete_chambre")
     * @IsGranted("ROLE_MANAGER")
     */
    public function deleteChambre ($id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(chambre::class);
        $chambre =  $repo->find($id);

        $entityManager->remove($chambre);
        $entityManager->flush();

        return $this->redirectToRoute('chambre_index_MANA');
    }

    /**
     * @Route("/chambre/view/{id_chambre}", name="view_chambre")
     * @IsGranted("ROLE_MANAGER")
     */
    public function viewChambre($id_chambre) {
        $repo = $this->getDoctrine()->getRepository(chambre::class);
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);

        $chambre = $repo->find($id_chambre);

        $taches = $repoTache->findBy([
            'chambre' => $chambre,
            'dateFin' => null
        ]);
        $chambre->nbTache = count($taches);

        return $this->render('chambre/viewChambre.html.twig', [
            'controller_name' => 'ChambreController',
            'chambre' => $chambre,
            'taches' => $taches
        ]);
    }

    
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
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);

        $chambres = $repo->findAll();

        foreach($chambres as $chambre){
            if($chambre->getStatut()->getID() == 3){
                $taches = $repoTache->findBy([
                    'chambre' => $chambre,
                    'dateFin' => null
                ]);

                if($taches <= 1){
                    $chambre->tacheNb = 0;
                }else{
                   $chambre->tacheNb = count($taches);
                }
            }else{
                $chambre->tacheNb = 0;
            }
            $chambresFull[] =$chambre;
            unset($taches);
        }



        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'chambres' => $chambresFull
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

    /**
     * @Route("/chambre/edit/new", name="edit_new_chambre")
     * @IsGranted("ROLE_MANAGER")
     */
    public function editChambreNewRequest (Request $request): Response {
        $chambre = new Chambre();

        $form = $this->createForm(ChambreType::class, $chambre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $chambreForm = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chambreForm);
            $entityManager->flush();

            return $this->redirectToRoute('chambre_index_MANA');
        }

        return $this->render('chambre/formChambre.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/chambre/update/{id}", name="update_chambre")
     * @IsGranted("ROLE_MANAGER")
     */
    public function updateChambre (Request $request, $id): Response {
        $chambre = new Chambre();
        $entityManager = $this->getDoctrine()->getManager();
        $chambre = $entityManager->getRepository(Chambre::class)->find($id);

        $form = $this->createForm(ChambreType::class, $chambre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $chambreForm = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chambreForm);
            $entityManager->flush();

            return $this->redirectToRoute('chambre_index_MANA');
        }

        return $this->render('chambre/formChambre.html.twig', [
            'form' => $form->createView(),
        ]);
    }


   

    
}
  