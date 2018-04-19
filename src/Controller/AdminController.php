<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Post;
use App\Form\PostType;


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
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        
        return $this->render('admin/posts.html.twig',[
            'posts' => $posts,
            'users' => $users]);
    }
    /**
     * @Route("/adminpanel/{thispost}/editpost", name="admineditpost")
     */
    public function editPosts(Request $request){
        
       //this post
       $stringid = $request->attributes->get('thispost');
       $postid = (int)$stringid;
       $repository = $this->getDoctrine()->getRepository(Post::class);
       $post = $repository->find($postid);
       $user = $post->getUser_id();
       $form = $this->createForm(PostType::class, $post); 
       
        //formulario
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $post=$form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($post);
           $em->flush();
           return $this->redirectToRoute('adminposts');
       }
           return $this->render('admin/editpost.html.twig', array(
            'user'=>$user,   
            'form' => $form->createView()            
        ));
    }
    
}
