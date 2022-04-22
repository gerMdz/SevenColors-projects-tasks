<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MasterSecurityController extends AbstractController
{
    /**
     * @Route("/master/login", name="app_master_login")
     */
    public function login(): Response
    {
        return $this->render('master_security/login.html.twig', [
//            'controller_name' => 'MasterSecurityController',
        ]);
    }
}
