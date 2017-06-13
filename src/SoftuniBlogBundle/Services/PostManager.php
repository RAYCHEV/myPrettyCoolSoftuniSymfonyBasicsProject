<?php

namespace SoftuniBlogBundle\Services;

use Doctrine\ORM\EntityManager;
use SoftuniBlogBundle\Entity\Post;

//use Symfony\Component\

class PostManager
{
    protected $em, $class, $container, $repository;
    public function __construct(EntityManager $em, $class, $container)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $this->em->getRepository($class);
        $this->container = $class;
    }

    public function createPost()
    {
        $class = $this->getClass();
        return new $class;
    }

    public function deletePost(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();
    }

    public function deletePosts($posts)
    {
        foreach ($posts as $post)
        {
            $this->deletePost($post);
        }
    }

    public function getPosts()
    {
        $posts = $this->repository->findAll();
        return $posts;
    }

    public function getPostsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function getClass()
    {
        return $this->class;
    }
}