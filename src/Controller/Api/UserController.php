<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * UserController API
 *
 * @author jgc
 */
class UserController extends Controller {
    private function serialize(User $user){
        return array(
            'username'=>$user->getUsername(),
            'email'=>$user->getEmail(),
            'password'=>$user->getPassword(),
            'role'=>$user->getRole(),
            'lastlogin'=>$user->getLastlogin()
        );
        
    }
   
    public function listUser($username=null){
        if ($username){
        $user=$this->getDoctrine()->getRepository(User::class)
                ->findOneBy(['username'=>$username]);
        
        
        return new JsonResponse($this->serialize($user));
        }else{
            $users=$this->getDoctrine()->getRepository(User::class)->findall();
            $data = array('users' => array());
            foreach ($users as $user) {
                $data['users'][] = $this->serialize($user);
            }
            
            $response = new Response(json_encode($data), 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            
            
        }
    }
    public function newUSer(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        //Request gets the paramters from url
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $error="";
        if(empty($name) || empty($email) || empty($password))
        {
          return $error="NULL VALUES ARE NOT ALLOWED"+ Response::HTTP_NOT_ACCEPTABLE; 
        }else{
            //If it gets the values of name, email and pass will create the new user:
            $user = new User();
            $s=date("Y-m-d H:i:s");
            $date = date_create_from_format('Y-m-d H:i:s', $s);
            $date->getTimestamp();

            $user->setLastlogin($date);
            $user->setRole('ROLE_USER');
            $password=$passwordEncoder->encodePassword($user, $password);
            $user->setPassword($password);
            $user->setUsername($name);
            $user->setEmail($email);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            //User registered
            
            $thisuser=$this->getDoctrine()->getRepository(User::class)
                ->findOneBy(['username'=>$name]);
        
        
            return new JsonResponse($this->serialize($thisuser));
            
        }
        
    }
}
