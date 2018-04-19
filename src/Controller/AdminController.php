<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class AdminController extends Controller
{
    
    /**
     * @Route("/adminpanel",name="adminpanel")
     */
    public function indexAction(){
        return $this->render('admin/panel.html.twig');
    }
    /**
     * @Route("/adminpanel/users",name="adminusers")
     */
    public function adminUsers(){
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        
        return $this->render('admin/users.html.twig',[
            'users' => $users]);
    }
    /**
     * @Route("/adminpanel/posts",name="adminposts")
     */
    public function adminPosts(){
        $posts = $this->getDoctrine()->getRepository('App:Post')->findAll();
        
        return $this->render('admin/posts.html.twig',[
            'posts' => $posts]);
    }
    
    
}
