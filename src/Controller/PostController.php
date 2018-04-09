<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;

class PostController extends Controller
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    
    /**
     * @Route("/newpost", name="newpost")
     */
    public function newPost(Request $request){
        
       $post=new Post();
       $user=$this->getUser();
       $post->setUser($user);
       $form = $this->createForm(PostType::class, $post); 
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $post=$form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($post);
           $em->flush();
           return $this->redirectToRoute('homeaction');
       }
           return $this->render('post/createpost.html.twig', array(
            'user'=>$user,   
            'form' => $form->createView()            
        ));
    }

}
