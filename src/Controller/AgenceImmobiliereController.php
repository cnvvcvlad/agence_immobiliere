<?php

namespace App\Controller;

use App\Entity\BiensImmobilier;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgenceImmobiliereController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('agence_immobiliere/index.html.twig', [
            'controller_name' => 'AgenceImmobiliereController',
        ]);
    }

    /**
     * @Route("/biens_immobiliers", name="biens_immobiliers")
     */

    public function biens_immobiliers(){
        $repo = $this->getDoctrine()->getRepository(BiensImmobilier::class);
        $biens_immo = $repo->findAll();
        return $this->render('agence_immobiliere/biens_immobiliers.html.twig', ["biens_immo" => $biens_immo]);
    }

}
