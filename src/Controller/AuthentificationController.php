<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\InscriptionType;
use App\Security\AppMainAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/authentification", name="authentification")
     */

     public function authentification(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder,GuardAuthenticatorHandler $guardHandler, AppMainAuthenticator $authenticator){
         $membre = new Membres();

         $form_inscription = $this->createForm(InscriptionType::class, $membre);
         $form_inscription->handleRequest($request);

         if($form_inscription->isSubmitted() && $form_inscription->isValid()){

             $membre->setPassword($encoder->encodePassword($membre,$membre->getPassword()));
             $membre->setDateInscription(new \DateTime());
             $membre->setRole("member");

             $manager->persist($membre);
             $manager->flush();

             return $guardHandler->authenticateUserAndHandleSuccess(
                $membre,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
         }



         return $this->render("agence_immobiliere/authentification.html.twig", ["form_inscription" => $form_inscription->createView(), "error"=>NULL,'last_username' => null]);
     }

     /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $membre = new Membres();
        $form_inscription = $this->createForm(InscriptionType::class, $membre);
        $form_connexion = $this->createForm(ConnexionType::class, $membre);

        return $this->render('agence_immobiliere/authentification.html.twig', [
            'last_username' => $lastUsername,
             'error' => $error,
             "form_inscription" => $form_inscription->createView(),
             "form_connexion" => $form_connexion->createView()
            ]);
    }

     /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
