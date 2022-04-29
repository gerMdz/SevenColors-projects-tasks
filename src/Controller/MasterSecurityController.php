<?php

namespace App\Controller;

use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MasterSecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_master_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->render('master_security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}
