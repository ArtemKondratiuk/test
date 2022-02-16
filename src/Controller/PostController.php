<?php

namespace App\Controller;

use App\Dto\NewCategoryDto;
use App\Dto\NewPostDto;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Security\PostVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    public function __construct(
        private postRepository $postRepository,
        private ValidatorInterface $validator
    ) {}

    public function showPost(): JsonResponse
    {
        $posts = $this->postRepository->showPost();

        return $this->json($posts);
    }

    public function showPostById(int $id): JsonResponse
    {
        $post = $this->postRepository->showPostById($id);

        return $this->json($post);
    }

    public function newPost(Request $request): Post
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException('Only for authenticated user');
        }

        $newPostDto = new NewPostDto();
        $newCategoryDto = new NewCategoryDto();
        $newPostDto->title = $request->get('title');
        $newPostDto->text = $request->get('text');

        $newCategoryDto->name = $request->get('category');

        $this->validator->validate($newCategoryDto);
        $this->validator->validate($newPostDto);
        return $this->postRepository->newPost($newPostDto, $newCategoryDto);
    }

    public function editPost(Request $request, Post $post): Post
    {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post, 'Posts can be edit by author or admin');

        $newPostDto = new NewPostDto();
        $newPostDto->title = $request->get('title');
        $newPostDto->text = $request->get('text');

        $newCategoryDto = new NewCategoryDto();
        $newCategoryDto->name = $request->get('category');

        $this->validator->validate($newCategoryDto);
        $this->validator->validate($newPostDto);
        $this->postRepository->editPost($newPostDto, $newCategoryDto, $post);

        return $this->postRepository->editPost($newPostDto, $newCategoryDto, $post);
    }

    public function removePost(Post $post): JsonResponse
    {
        $this->denyAccessUnlessGranted(PostVoter::REMOVE, $post, 'Posts can be remove by author or admin');

        $this->postRepository->removePost($post);

        return $this->json(['message' => 'post successfully deleted'], 200);
    }
}
