<?php

namespace App\Service;

use App\Dto\NewCategoryDto;
use App\Dto\NewPostDto;
use App\Entity\Category;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PostService
{
    public function __construct(
        public EntityManagerInterface $em,
        public Security $security,
        public PostRepository $postRepository,
        public AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function showPost()
    {
        return $this->postRepository->findAll();
    }

    public function showPostById(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function newPost(NewPostDto $newPostDto, NewCategoryDto $newCategoryDto)
    {
        $post = new Post();
        $category = new Category();

        if(!$this->authorizationChecker->isGranted('new', $post)) {
            throw new AccessDeniedException('Posts can be create by user or admin');
        }

        $category->setName($newCategoryDto->getName());

        $post->setTitle($newPostDto->getTitle())
            ->setText($newPostDto->getText())
            ->setAuthor($this->security->getUser())
            ->addCategory($category)
        ;

        $this->em->persist($category);
        $this->em->persist($post);
        $this->em->flush();
    }

    public function editPost(NewPostDto $newPostDto, Post $post)
    {
        if(!$this->authorizationChecker->isGranted('edit', $post)) {
            throw new AccessDeniedException('Posts can be edit by author or admin');
        }

        $post->setTitle($newPostDto->getTitle())
            ->setText($newPostDto->getText())
            ->setAuthor($this->security->getUser())
        ;

        $this->em->flush();
    }

    public function removePost(Post $post)
    {
        if(!$this->authorizationChecker->isGranted('delete', $post)) {
            throw new AccessDeniedException('Posts can be remove by author or admin');
        }

        $this->em->remove($post);
        $this->em->flush();
    }
}
