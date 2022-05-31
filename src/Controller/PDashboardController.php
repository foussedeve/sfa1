<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PDashboardController extends AbstractController
{
    /**
     * @Route("/parent/dashboard", name="app_p_dashboard")
     */
    public function index(): Response
    {
        return $this->render('p_dashboard/index.html.twig', [
            'controller_name' => 'PDashboardController',
        ]);
    }

     /**
     * @Route("/parent/eleves", name="parent_eleves")
     */
    public function getParentEleves( EleveRepository $eleveRepo): Response
    {
        /**
         * @var User
         */
        $parent=$this->getUser();
        return $this->render('p_dashboard/eleves.html.twig', [
           "eleves"=>$parent->getEleves()
        ]);
    }
     /**
     * @Route("/parent/eleve/notes/{id}", name="eleve_notes")
     */
    public function getEleveNotes( Eleve $eleve): Response
    {
       
        return $this->render('p_dashboard/eleve.notes.html.twig', [
           "notes"=>$eleve->getNotes(),
           "eleve" =>$eleve

        ]);
    }
}
