<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Security\UsersAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthentificationController extends AbstractController
{



    /**
     * @Route("/authentification", name="authentification")
     */

    public function authentification(Request $request, TranslatorInterface $translator)
    {
        $membre = new Membres();
        $form_inscription = $this->createForm(InscriptionType::class, $membre);
        $form_inscription->handleRequest($request);

        if ($form_inscription->isSubmitted() && $form_inscription->isValid()) {

            $membre->setDateInscription(new \DateTime());

            $membre->setRole('user');

            // on enregistre les informations dans la base de donn�es pour l'utilisateur qui vient de s'inscrire
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();


            //Traduction de la chaine de caractère
            $traslated_message = $translator->trans('User successfully registered');
            // On génère un message pour la view
            $this->addFlash('message', $traslated_message);

            // On retourne au formulaire de connexion
            return $this->redirectToRoute('authentification');
        }


        $form_connexion = $this->createForm(ConnexionType::class, $membre);

        if ($form_connexion->isSubmitted() && $form_connexion->isValid())
        {
            return $this->redirectToRoute('home');
        }


        return $this->render("authentification/authentification.html.twig", ["form_inscription" => $form_inscription->createView(), "form_connexion" => $form_connexion->createView()]);
    }
}
