<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Form\CommentType;

class CommentController extends Controller
{
    /**
     * @Route("/post/{thispost}/addcomment", name="addcomment")
     */
    public function newComment(Request $request){
        
       $comment=new Comment();
       $user=$this->getUser();
       $post=$this->//AQUIMEQUEDADO
       $post->setUser($user);
       $form = $this->createForm(PostType::class, $post); 
       
        //formulario
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
