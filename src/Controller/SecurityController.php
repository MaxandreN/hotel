<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     */
    public function login(): Response
    {
        return $this->render('security/idex.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
       // $this->denyAccessUnlessGranted('ROLE_USER');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on tour firwall.');
    }
}
