<?php

namespace App\Service;

use App\Dto\NewPostDto;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class PostService
{
    public function __construct(
        public EntityManagerInterface $em,
        public Security $security,
    ) {}

    public function showPost()
    {
        $posts =  $this->em->getRepository('App:Post')->findAll();

        if (!$posts) {
            throw new NotFoundHttpException("not exist");
        }

        return $posts;
    }

    public function showPostById(int $id)
    {
         $post = $this->em->getRepository('App:Post')->find($id);

        if (!$post) {
            throw new NotFoundHttpException("not exist");
        }

        return $post;
    }

    public function newPost(NewPostDto $newPostDto)
    {
        $post = new Post();
        $post->setTitle($newPostDto->getTitle())
            ->setContent($newPostDto->getContent())
            ->setAuthor($this->security->getUser())
        ;

        $this->em->persist($post);
        $this->em->flush();
    }

    public function editPost(NewPostDto $newPostDto, Post $post)
    {
        $post->setTitle($newPostDto->getTitle())
            ->setContent($newPostDto->getContent())
            ->setAuthor($this->security->getUser())
        ;

        $this->em->flush();
    }

    public function removePost(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();
    }
}
