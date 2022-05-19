<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use App\Entity\Eleve;
use App\Entity\User;
use App\Entity\Classe;
use App\Form\EleveType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EEleveController extends AbstractController
{
    /**
     * @var instanceof EleveRepository
     */
    private $eleveRepo;
    public function __construct(EleveRepository $eleveRepo)
    {
        $this->eleveRepo = $eleveRepo;
    }

    /**
     * @Route("/ecole/eleves", name="app_eleve")
     */
    public function index(): Response
    {
        $eleves=$this->eleveRepo->findAll();
        return $this->render('e_eleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }

    /**
     * @Route("/ecole/eleve/add", name="add_eleve")
     */
    public function addEleve(Request $request): Response
    {

        $eleve = new Eleve();
        
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {        
            $this->eleveRepo->add($eleve,true);
            $this->addFlash("success", "Elève  ajouté avec succès");
            return $this->redirectToRoute("app_eleve");
        }
        return $this->renderForm('e_eleve/add.html.twig', [
            "form" => $form
        ]);
    }

     /**
     * @Route("/ecole/eleve/edit/{id}", name="edit_eleve")
     */
    public function editEleve(Request $request,Eleve $eleve): Response
    {
        
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $this->eleveRepo->add($eleve,true);
            $this->addFlash("success", "Elève  modifié avec succès");
            return $this->redirectToRoute("app_eleve");
        }
        return $this->renderForm('e_eleve/edit.html.twig', [
            "form" => $form
        ]);
    }

        /**
     * @Route("/ecole/eleve/del/{id}", name="del_eleve")
     */
    public function delParent(Request $request,Eleve $eleve): Response
    {
        $this->eleveRepo->remove($eleve,true);
            $this->addFlash("success", "eleve suppimé avec succès");
            return $this->redirectToRoute("app_eleve");

    }
}
