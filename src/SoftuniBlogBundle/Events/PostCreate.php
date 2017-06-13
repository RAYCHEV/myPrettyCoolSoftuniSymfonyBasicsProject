<?php


namespace SoftuniBlogBundle\Events;


use SoftuniBlogBundle\Entity\Post;
use Symfony\Component\EventDispatcher\Event;

class PostCreate extends Event
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}