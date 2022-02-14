<?php

namespace App\Controller;

use App\Dto\NewPostDto;
use App\Entity\Post;
use App\Service\PostService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[IsGranted('ROLE_USER')]
    public function newPost(Request $request)
    {
        $newPostDto = new NewPostDto();
        $newPostDto->setTitle(json_decode($request->getContent(), true)['title'])
            ->setContent(json_decode($request->getContent(), true)['content'])
        ;

        $this->validator->validate($newPostDto);
        $this->postService->newPost($newPostDto);

        return $this->json($newPostDto);
    }

    #[IsGranted('ROLE_USER')]
    public function editPost(Request $request, Post $post)
    {
        $newPostDto = new NewPostDto();
        $newPostDto->setTitle(json_decode($request->getContent(), true)['title'])
            ->setContent(json_decode($request->getContent(), true)['content'])
        ;

        $this->validator->validate($newPostDto);
        $this->postService->editPost($newPostDto, $post);

        return $this->json($newPostDto);
    }

    #[IsGranted('ROLE_USER')]
    public function removePost(Post $post)
    {
        $this->postService->removePost($post);

        return $this->json(['message' => 'post successfully deleted'], 200);
    }
}
