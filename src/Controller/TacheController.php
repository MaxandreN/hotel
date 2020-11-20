<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Statut;
use App\Entity\Tache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotNull;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TacheController extends AbstractController
{
    /**
     * @Route("/MyTache", name="tache_My")
     * @IsGranted("ROLE_USER")
     */
    public function getMyTache(): Response
    {
        //app.user.username
        $user = $this->getUser();
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);
        $taches = $repoTache->findBy([
            'user' => $user,
            'dateFin' => NULL
        ]);



        return $this->render('tache/MyTache.html.twig', [
            'controller_name' => 'MyTache',
            'taches' => $taches
        ]);

    }

     /**
     * @Route("/EndTache/{id_tache}", name="end_Tache")
     * @IsGranted("ROLE_USER")
     */
    public function setTacheEnd($id_tache): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);
        $repoChambre = $this->getDoctrine()->getRepository(Chambre::class);
        $repoStatut = $this->getDoctrine()->getRepository(Statut::class);
        $tache = $repoTache->findOneBy([
            'user' => $user,
            'id' => $id_tache,
            'dateFin' => NULL
        ]);

        $chambre = $repoChambre->find($tache->getChambre()->getId());
        $statut = $repoStatut ->findOneBy([
            'id' => 1
        ]);
        

        $tache->setDateFin();
        $chambre->setStatut($statut);

        $entityManager->persist($tache);
        $entityManager->persist($chambre);
        $entityManager->flush();

        return $this->redirectToRoute('tache_My');

    }

    /**
     * @Route("/tache/edit/chambre/{id}", name="tache_edit_chambre")
     * @IsGranted("ROLE_MANAGER")
     */
    public function addTacheEditChambre($id): Response
    {
        $repoChamber = $this->getDoctrine()->getRepository(Chambre::class);        
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoTache =$this->getDoctrine()->getRepository(Tache::class);

        $user = $repoUser->find($id);

        $chambres = $repoChamber->findAll();

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



        return $this->render('tache/byUser.html.twig', [
            'controller_name' => 'SalarieController',
            'chambres' => $chambresFull,
            'user' => $user
        ]);

    }

    /**
     * @Route("/tache/edit/user/{id}", name="tache_edit_user")
     * @IsGranted("ROLE_MANAGER")
     */
    public function addTacheEditUser($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $repoChambre = $this->getDoctrine()->getRepository(Chambre::class);
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);

        $Users = $repo->findBy(['fonction' => 1]);
        $chambre = $repoChambre->find($id);

        foreach($Users as $user){
            $tacheTest = $repoTache->findOneBy([
                'user' => $user,
                'chambre' => $chambre,
                'dateFin' => NULL
            ]);
            
            $taches = $repoTache->findBy([
                'user' => $user,
                'dateFin' => NULL
                ]);


            if($tacheTest != null){
                $user->libre = false;
                $user->tache = $tacheTest->getId();

            }else{
                $user->libre = true;

            }


            $user->nbTache = count($taches);
            $UsersFull[] = $user;
            unset($taches);


            
        }
        return $this->render('tache/byChambre.html.twig', [
            'controller_name' => 'ChambreController',
            'users' => $UsersFull,
            'chambre' => $chambre
        ]);
    }

    /**
     * @Route("/tache/edit/{id_chambre}/{id_user}", name="tache_edit")
     * @IsGranted("ROLE_MANAGER")
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

        return $this->redirectToRoute('home');
    }


        /**
     * @Route("/tache/del/{id_tache}", name="tache_del")
     * @IsGranted("ROLE_MANAGER")
     */
    public function delTache($id_tache): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoTache = $entityManager->getRepository(Tache::class);

        $tache = $repoTache->find($id_tache);
        $entityManager->remove($tache);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
