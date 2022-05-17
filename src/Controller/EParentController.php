<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EParentController extends AbstractController
{
    /**
     * @Route("/e/parent", name="app_e_parent")
     */
    public function index(): Response
    {
        return $this->render('e_parent/index.html.twig', [
            'controller_name' => 'EParentController',
        ]);
    }
}
