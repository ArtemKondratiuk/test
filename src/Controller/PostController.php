<?php

namespace App\Controller;

use App\Dto\NewCategoryDto;
use App\Dto\NewPostDto;
use App\Entity\Post;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    public function __construct(
        public PostService $postService,
        public ValidatorInterface $validator
    ) {}

    public function showPost()
    {
        $posts = $this->postService->showPost();

        return $this->json($posts);
    }

    public function showPostById(int $id)
    {
        $post = $this->postService->showPostById($id);

        return $this->json($post);
    }

    public function newPost(Request $request)
    {
        $newPostDto = new NewPostDto();
        $newCategoryDto = new NewCategoryDto();
//        $newPostDto->setTitle(json_decode($request->getContent(), true)['title'])
//            ->setContent(json_decode($request->getContent(), true)['content'])
//        ;
        $newPostDto->setTitle($request->get('title')
                ->setText($request->get('text')
                )
        );

        $newCategoryDto->setName($request->get('name'));

        $this->validator->validate($newCategoryDto);
        $this->validator->validate($newPostDto);
//        $post = $this->postService->newPost($newPostDto);
//        return $post;
        return $this->json($newPostDto);
    }

    public function editPost(Request $request, Post $post)
    {
        $newPostDto = new NewPostDto();
//        $newPostDto->setTitle(json_decode($request->getContent(), true)['title'])
//            ->setContent(json_decode($request->getContent(), true)['content'])
//        ;

        $newPostDto->setTitle($request->get('title')
            ->setText($request->get('text'))
        );

        $this->validator->validate($newPostDto);
        $this->postService->editPost($newPostDto, $post);

        return $this->json($newPostDto);
    }

    public function removePost(Post $post)
    {
        $this->postService->removePost($post);

        return $this->json(['message' => 'post successfully deleted'], 200);
    }
}
