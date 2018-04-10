<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
