<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/authentification", name="authentification")
     */

     public function authentification(){
         $membre = new Membres();
         $form_inscription = $this->createForm(InscriptionType::class, $membre);
         $form_connexion = $this->createForm(ConnexionType::class, $membre);

         return $this->render("agence_immobiliere/authentification.html.twig", ["form_inscription" => $form_inscription->createView(), "form_connexion" => $form_connexion->createView()]);
     }
}
