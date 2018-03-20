<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    
    /**
     *@ORM\Column(type="string",length=45)
     */
    private $comment;
    /**
     *@ORM\Column(type="datetime")
     */
    private $create_date;
    
    /**
     * @ORM\ManyToOne(targetEntity= "App\Entity\User",inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    function getUser():Role{
        return $this->role;
    }
    function setUser(User $user){
        $this->role=$user;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity= "App\Entity\Post",inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;
    function getPost():Role{
        return $this->post;
    }
    function setPost(Post $post){
        $this->role=post;
    }

   
    function getComment() {
        return $this->comment;
    }

    function getCreate_date() {
        return $this->create_date;
    }


    function setComment($comment) {
        $this->comment = $comment;
    }

    function setCreate_date($create_date) {
        $this->create_date = $create_date;
    }

    function getId() {
        return $this->id;
    }


    
}
