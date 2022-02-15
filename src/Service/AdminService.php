<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminService
{
    public function __construct(
        public UserRepository $userRepository,
        public PostRepository $postRepository,
        public AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function showUsers()
    {
        if(!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Users can be show by admin');
        }

        return $this->userRepository->findAll();
    }

    public function showPosts()
    {
        if(!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Posts can be show admin');
        }

        return $this->postRepository->findAll();
    }
}