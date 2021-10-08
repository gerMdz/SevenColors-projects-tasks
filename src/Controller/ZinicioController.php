<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZinicioController extends AbstractController
{
    /**
     * @Route("/api", name="zinicio")
     */
    public function index(): Response
    {
        return $this->render('zinicio/index.html.twig', [
            'controller_name' => 'ZinicioController',
        ]);
    }

    /**
     * @Route("/api/docs", name="zinicio_docs")
     */
    public function apiDocs(): Response
    {
        return $this->render('zinicio/index.html.twig', [
            'controller_name' => 'ZinicioController',
        ]);
    }

    /**
     * @Route("/inicio", name="app_inicio")
     */
    public function inicio(): Response
    {
        return $this->render('zinicio/index.html.twig', [
            'controller_name' => 'ZinicioController',
        ]);
    }
}
