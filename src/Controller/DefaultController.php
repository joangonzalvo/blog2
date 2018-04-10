<?php



namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of DefaultController
 *
 * @author linux
 */
class DefaultController extends Controller{
    
    /**
     * @Route("/",name="homeaction")
     */
    public function indexAction($name='demo'){
        $posts = $this->getDoctrine()->getRepository('App:Post')->findAll();
        
        return $this->render('default/index.html.twig',[
            'name'=> $name,
            'posts' => $posts]);
    }
}
