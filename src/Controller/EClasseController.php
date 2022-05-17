<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EClasseController extends AbstractController
{
    private $em;
    public function __construct(ManagerRegistry $manager)
    {
        $this->em = $manager->getManager();
    }

    /**
     * @Route("/ecole/classes", name="ecole_classe")
     */
    public function index(ClasseRepository $classeRepo): Response
    {
        $classes = $classeRepo->findAll();
        return $this->render('e_classe/index.html.twig', [
            'classes' => $classes,
        ]);
    }

    /**
     * @Route("/ecole/classe/add", name="add_classe")
     * @Route("/ecole/classe/edit/{id}", name="edit_classe")
     */
    public function addClasse(Request $request, classe $classe = null): Response
    {
        if ($classe == null) {
            $classe = new Classe();
        }

        $form = $this->createForm(ClasseType::class, $classe);

        // request traitement
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($classe);
            $this->em->flush();
            $this->addFlash("success","Classe ajoutée avec succès");
            return $this->redirectToRoute("ecole_classe");
        }

        return $this->renderForm('e_classe/add.html.twig', [
            "form" => $form,
            "editMode" => $classe->getId() == null,
            "title" => $classe->getId() == null ? "Ajouter une nouvelle Classe" : "Modifier la classe"
        ]);
    }
}
