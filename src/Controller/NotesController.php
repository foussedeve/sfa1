<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\ClasseRepository;
use App\Repository\EleveRepository;
use App\Repository\NoteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends AbstractController
{

    /**
     * @var instanceof NoteRepository
     * 
     */
    private $noteRepo;
    public function __construct(NoteRepository $noteRepo)
    {
        $this->noteRepo = $noteRepo;
    }




    /**
     * @Route("/ecole/notes", name="app_notes")
     */
    public function index(): Response
    {

        $notes = $this->noteRepo->findBy([], ["id" => "DESC"]);
        return $this->render('notes/index.html.twig', [
            "notes" => $notes
        ]);
    }

    /**
     * @Route("/ecole/notes/add", name="add_notes")
     */
    public function addNotes(): Response
    {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('add_step1_notes'))
            ->add('matiere', TextType::class)
            ->add('class', EntityType::class, [
                "class" => Classe::class
            ])

            ->setMethod("GET")
            ->getForm();
        return $this->renderForm('notes/add.html.twig', [
            "form" => $form
        ]);
    }

    /**
     * @Route("/ecole/notes/add/step2", name="add_step1_notes")
     */
    public function addStepNotes(Request $request, ClasseRepository $classeRepo): Response
    {

        $formData = $request->get("form");
        $matiere = $formData["matiere"];
        $classeId = $formData["class"];

        $eleves = $classeRepo->find($classeId)->getEleves();

        $formBuilder = $this->createFormBuilder();
        foreach ($eleves as $eleve) {
            $label = $eleve->getMatricule() . " - " . $eleve->getNom() . " " . $eleve->getPrenom();
            $champName = "note_" . $eleve->getId();
            $formBuilder->add($champName, TextType::class, [
                "label" => $label,
                "attr" => [
                    "class" => "form-control mb-2"
                ]
            ]);
        }

        $formBuilder->add("class", HiddenType::class, [
            "attr" => [
                "value" => $classeId,
            ],
        ]);

        $formBuilder->add("matiere", HiddenType::class, [

            "attr" => [
                "value" => $matiere,
            ]
        ]);
        $formBuilder->add("Enregistrez", SubmitType::class, [
            "attr" => [
                "class" => "btn btn-primary bg-info mt-3  mr-2"
            ]
        ]);
        $form = $formBuilder->getForm();


        //traitemant de la requete
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
           
            foreach ($eleves as $eleve) {
                $champName = "note_" . $eleve->getId();
                $eleveNote = $data[$champName];
                $note = new Note();
                $note->setMatiere($data["matiere"])
                    ->setNote($eleveNote);
                $eleve->addNote($note);
                $this->noteRepo->add($note);
            }
            $this->addFlash("success", "Notes ajoutées avec succès");
            return $this->redirectToRoute("app_notes");
        }

        return $this->renderForm('notes/add2.html.twig', [
            "form" => $form
        ]);
    }



    /**
     * @Route("/ecole/notes/edit/{id}", name="edit_note")
     */
    public function editNotes(Note $note, Request $request): Response
    {

        $form = $this->createForm(NoteType::class, $note);

        // traitement de la requete
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteRepo->add($note, true);
            $this->addFlash("success", "Note modifiée avec succès");
            return $this->redirectToRoute("app_notes");
        }

        return $this->renderForm('notes/edit.html.twig', [
            "form" => $form
        ]);
    }
    /**
     * @Route("/ecole/notes/del/{id}", name="del_note")
     */
    public function delNotes(Note $note): Response
    {
        $this->noteRepo->remove($note, true);
        $this->addFlash("success", "Note suppimée avec succès");
        return $this->redirectToRoute("app_notes");
    }
}
