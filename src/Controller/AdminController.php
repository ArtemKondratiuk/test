<?php

namespace App\Controller;

use App\Service\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends AbstractController
{
    public function __construct(
        private AdminService $adminService,
    ) {}

    public function showPosts(): JsonResponse
    {
        if(!$this->isGranted(['ROLE_ADMIN'])) {
            throw new AccessDeniedException('Only for admin');
        }

        $posts = $this->adminService->showPosts();

        return $this->json($posts);
    }

    public function showUsers(): JsonResponse
    {
        if(!$this->isGranted(['ROLE_ADMIN'])) {
            throw new AccessDeniedException('Only for admin');
        }

        $users = $this->adminService->showUsers();

        return $this->json($users);
    }
}
