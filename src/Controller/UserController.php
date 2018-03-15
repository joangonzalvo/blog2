<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Form\RegisterType;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    public function __construct() {
        $this->session= new Session();
    }
    
    /**
     * @Route("/login",name="login")
     */
    public function login(Request $request,AuthenticationUtils $authUtils){
        $error=$authUtils->getLastAuthenticationError();
        //last Username
        $lastUsername=$authUtils->getLastUsername();
        
        return $this->render('user/login.html.twig',[
            'error'=>$error,
            'last_username'=>$lastUsername
        ]);
    }
    
    public function logout(){
        $this->redirectToRoute('logout');
    }
    
    
    //REGISTER
    
    /**
     * @Route("/register",name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $s=date("Y-m-d H:i:s");
        $date = date_create_from_format('Y-m-d H:i:s', $s);
        $date->getTimestamp();
        
        $user->setLastlogin($date);
        $user->setRole('user');
        
        //creating the form
        $form = $this->createForm(RegisterType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encoding password, first we get password in plaintext and then
    // we encode it.
            $password=$passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $status="User registred";
            $this->session->getFlashBag()->add("status",$status);
            
            return $this->redirectToRoute('homeaction');
        }
        //rendering form
        return $this->render('user/regform.html.twig', array(
            'form' => $form->createView(),
        ));
         
    }

    
    
}
