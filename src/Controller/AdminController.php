<?php

namespace App\Controller;

use App\Service\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends AbstractController
{
    public function __construct(
        private AdminService $adminService,
    ) {}

    public function showPosts(): JsonResponse
    {
        $this->isGranted(['ROLE_ADMIN']);

        $posts = $this->adminService->showPosts();

        return $this->json($posts);
    }

    public function showUsers(): JsonResponse
    {
        $this->isGranted(['ROLE_ADMIN']);

        $users = $this->adminService->showUsers();

        return $this->json($users);
    }
}
