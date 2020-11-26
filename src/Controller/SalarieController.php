<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Statut;
use App\Entity\Tache;
use App\Form\UserType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SalarieController extends AbstractController
{    
            /**
     * @Route("/salarie/{id}", name="salarie_By_Id")
     * @IsGranted("ROLE_MANAGER")
     */
    public function getSalarieById($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $repoTache = $this->getDoctrine()->getRepository(Tache::class);

        $user = $repo->find($id);

        $taches = $repoTache->findBy([
            'user' => $user,
            'dateFin' => null
        ]);
        $user->nbTache = count($taches);

        return $this->render('salarie/viwSalarie.html.twig', [
            'controller_name' => 'SalarieController',
            'user' => $user,
            'taches' => $taches
        ]);
    }
    
    /**
     * @Route("/salarie", name="salaries_all")
     * @IsGranted("ROLE_MANAGER")
     */
    public function getSalaries(): Response
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

        /**
     * @Route("/salarie/edit/new", name="edit_new_salarie")
     */
    public function editUserNewRequest (Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $userForm = $form->getData();

            $mdp = $form ->get('passwordEncod')->getData();
            $userForm->setPassword($passwordEncoder->encodePassword($userForm, $mdp));

            

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userForm);
            $entityManager->flush();

            return $this->redirectToRoute('salaries_all');
        }

        return $this->render('salarie/formUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/user/update/{id_user}", name="update_salarie")
    */
    public function updateUserNewRequest (Request $request, UserPasswordEncoderInterface $passwordEncoder, $id_user): Response {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->find($id_user);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $userForm = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager->persist($userForm);
            $entityManager->flush();

            return $this->redirectToRoute('salaries_all');
        }

        return $this->render('salarie/formUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
    * @Route("/user/delete/{id_user}", name="delete_salarie")
    */
    public function deleteUser ($id_user) {
 
        $entityManager = $this->getDoctrine()->getManager();
        $repoUser = $this->getDoctrine()->getRepository(User::class);

        $user = $repoUser->find($id_user);

        $taches = $entityManager->getRepository(Tache::class)->findBy(['user' => $user]);

         foreach($taches as $tache){
             $tache->setDateFin();
             $entityManager->persist($tache);

        }
        
        $entityManager->remove($user);

        $entityManager->flush();

        return $this->redirectToRoute('salaries_all');
        
    }

}
