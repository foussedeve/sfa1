<?php 
namespace App\Service;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EnvoieNoteService{

private $mailer;


public function __construct(MailerInterface $mailer){

    $this->mailer=$mailer;
}

public function envoyerNote($tabNote){

 foreach($tabNote as $tab){

   $email=$tab["email"];
   $note=$tab["note"];
   $matiere=$tab["matiere"];
   $eleve=$tab["eleve"];
   $msg="Note de $eleve en $matiere : $note";
   $mail = new Email();
        $mail ->from('grecomgd@gmail.com')
            ->to($email)
            ->subject("Envoie de note")
            ->text($msg);

    $this->mailer->send($mail);
 }

}

} 