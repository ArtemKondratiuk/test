<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Repository\UserRepository;

class AdminService
{
    public function __construct(
        private UserRepository $userRepository,
        private PostRepository $postRepository,
    ) {}

    public function showUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function showPosts(): array
    {
        return $this->postRepository->findAll();
    }
}
