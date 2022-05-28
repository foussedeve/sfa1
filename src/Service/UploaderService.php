<?php 
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderService{

private $directory;
private $newFilename;


public function __construct($dossier){

    $this->directory=$dossier;
}
 public function ulpoader(UploadedFile $fichier,$filename=null){

   if($filename==null){
       $filename=uniqid();
   }
   $newFilename=$filename.".".$fichier->guessExtension();
   $fichier->move($this->directory,$newFilename);

 }

}