<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ParentPasswordType;
use App\Form\ParentType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EParentController extends AbstractController
{

    /**
     * @var instanceof UserRepository
     */
    private  $parentRepo;
    /**
     * @var instanceof UserpasswordHahser
     * 
     */
    private $passwordHasher;
    public function __construct(UserRepository $parentRepo, UserPasswordHasherInterface $passwordHasher)
    {
        $this->parentRepo = $parentRepo;
        $this->passwordHasher = $passwordHasher;
    }
    /**
     * @Route("/ecole/parents", name="app_parent")
     */
    public function index(): Response
    {

        $parents = $this->parentRepo->findBy(["isParent" => true]);
        return $this->render('e_parent/index.html.twig', [
            "parents" => $parents
        ]);
    }


    /**
     * @Route("/ecole/parent/add", name="add_parent")
     */
    public function addParent(Request $request): Response
    {
        $parent = new User();
        $parent->setIsParent(true)
            ->setIsActif(true)
            ->setRoles(["ROLE_PARENT"]);
        $form = $this->createForm(ParentType::class, $parent);

        // request traitement
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $parent->getPassword();
            $parent->setPassword($this->passwordHasher->hashPassword($parent, $password));
            $this->parentRepo->add($parent,true);
            $this->addFlash("success", "Parent ajouté avec succès");
            return $this->redirectToRoute("app_parent");
        }

        return $this->renderForm('e_parent/add.html.twig', [
            "form" => $form,
        ]);
    }

    /**
     * @Route("/ecole/parent/edit/{id}", name="edit_parent")
     */
    public function editParent(User $parent, Request $request): Response
    {

        $form = $this->createForm(ParentType::class, $parent);

        // request traitement
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->parentRepo->add($parent,true);
            $this->addFlash("success", "Parent modifié avec succès");
            return $this->redirectToRoute("app_parent");
        }

        return $this->renderForm('e_parent/edit.html.twig', [
            "form" => $form,
        ]);
    }

      /**
     * @Route("/ecole/parent/del/{id}", name="del_parent")
     */
    public function delParent(Request $request,User $parent): Response
    {
        $this->parentRepo->remove($parent,true);
            $this->addFlash("success", "Parent suppimé avec succès");
            return $this->redirectToRoute("app_parent");

    }

     /**
     * @Route("/ecole/parent/edit/password/{id}", name="edit_password_parent")
     */
    public function editPasswordParent(User $parent, Request $request): Response
    {

        $form = $this->createForm(ParentPasswordType::class, $parent);

        // request traitement
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password=$request->get("parent_password")["mdp"]["first"];
            $mdpCryp=$this->passwordHasher->hashPassword($parent, $password);
            $parent->setPassword($mdpCryp);
            $this->parentRepo->add($parent,true);
            $this->addFlash("success", "Parent password modifié avec succès");
            return $this->redirectToRoute("app_parent");
        }

        return $this->renderForm('e_parent/edit.password.html.twig', [
            "form" => $form,
        ]);
    }
}
