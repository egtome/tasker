<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $user->setRole('ROLE_USER');
            $passwordEncoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordEncoded);
            $right_now =  (new \DateTime())->format('m-d-Y H:i:s');
            $user->setCreatedAt(new \Datetime('now'));
            
            //Save user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('tasks');
        }
        
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    public function login(AuthenticationUtils $authUtils)
    {
        $user = $this->getUser();
        if($user !== null){
            return $this->redirectToRoute('tasks',[],302);
        }
        
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername     
        ]); 
    }
}
