<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EClasseController extends AbstractController
{
    /**
     * @Route("/classes", name="ecole_classe")
     */
    public function index(): Response
    {
        return $this->render('e_classe/index.html.twig', [
            'controller_name' => 'EClasseController',
        ]);
    }

    /**
     * @Route("/classe/add", name="add_classe")
     */
    public function addClasse(): Response
    {$classe=new Classe();
        $classeForm=$this->createForm(ClasseType::class,$classe);

        return $this->renderForm('e_classe/add.html.twig', [
           "form"=>$classeForm
        ]);
    }
}
