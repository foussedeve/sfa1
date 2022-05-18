<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EEleveController extends AbstractController
{
    /**
     * @Route("/e/eleve", name="app_e_eleve")
     */
    public function index(): Response
    {
        return $this->render('e_eleve/index.html.twig', [
            'controller_name' => 'EEleveController',
        ]);
    }
}
