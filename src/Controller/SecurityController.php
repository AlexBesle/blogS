<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * 
     * @Route ("/inscription", name="security_registration")
     */

     public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
     {

        $user = new User;

        $formRegistration = $this->createForm(RegistrationFormType::class, $user);


dump($request);

$formRegistration->handleRequest($request);

dump($user);

if($formRegistration->isSubmitted() && $formRegistration->isValid() )
{

    $hash = $encoder->encodePassword($user, $user->getPassword());

    dump($hash);

    $user->setPassword($hash);

    $manager->persist($user);
    $manager->flush();


    $this->addFlash('success', "Felicitation ton compte est validé!!!");

    return $this->redirectToRoute('security_login');

}

         return $this->render('security/registration.html.twig', [
             'formRegistration' => $formRegistration->createView()
         ]);
     }


     /**
      * @Route("/connexion", name ="security_login")
      */

      public function login(): Response
      {
          return $this->render('security/login.html.twig');
      }


      /**
       * 
       * @Route("/deconnexion", name="security_logout")
       * 
       * 
       */

       public function logout()
       {
           
       }
}
