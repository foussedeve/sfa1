<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EDashboardController extends AbstractController
{
    /**
     * @Route("/ecole/dashboard", name="app_e_dashboard")
     */
    public function index(): Response
    {
        return $this->render('e_dashboard/index.html.twig', [
            'controller_name' => 'EDashboardController',
        ]);
    }
}
