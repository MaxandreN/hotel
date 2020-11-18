<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Tache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TacheController extends AbstractController
{
    /**
     * @Route("/tache", name="tache")
     */
    public function index(): Response
    {
        return $this->render('tache/index.html.twig', [
            'controller_name' => 'TacheController',
        ]);
    }

    /**
     * @Route("/tache/edit/chambre/{id}", name="tache_edit_chambre")
     */
    public function addTacheChambre($id): Response
    {
        $repoChambre = $this->getDoctrine()->getRepository(Chambre::class);
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);
        $chambre = $repoChambre->find($id);
        $users = $repoUser->findBy([
            'fonction' => 1,
        ]);
        $taches = $repoTache->findBy([
            'dateFin' => NULL
        ]);

        foreach($users as $user){
            //dd($tache->getUser());
            $tache = $repoTache->findOneBy([
                'dateFin' => NULL,
                'user' => $user
            ]);
            
            if($tache == null){
                $usersFree[] = $user;
            }
        }

        return $this->render('tache/byChambre.html.twig', [
            'controller_name' => 'TacheController',
            'chambre' => $chambre,
            'users' => $usersFree
        ]);


    }

            /**
     * @Route("/tache/edit/user/{id}", name="tache_edit_user")
     */
    public function addTacheUser(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Tache::class);

        $chambres = $repo->findAll();

        return $this->render('tache/index.html.twig', [
            'controller_name' => 'TacheController',
        ]);
    }

    /**
     * @Route("/tache/edit/{id_chambre}/{id_user}", name="tache_edit")
     */
    public function addTache($id_chambre, $id_user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoChambre = $entityManager->getRepository(Chambre::class);
        $repoUser = $entityManager->getRepository(User::class);
        
        $dateFormat = "Y-m-d H:i:s";
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now'));

        $user = $repoUser->find($id_user);
        $chambre = $repoChambre->find($id_chambre);
        $tache = new tache ;
        $tache->setUser($user)
            ->setChambre($chambre)
            ->setDateDebut();
        
        $entityManager->persist($tache);
        $entityManager->flush();

        return $this->redirectToRoute('chambre_index_MANA');
    }
}
