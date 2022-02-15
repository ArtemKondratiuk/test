<?php

namespace App\Controller;

use App\Service\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function __construct(
        public AdminService $adminService,
    ) {}

    public function showPosts()
    {
        $posts = $this->adminService->showPosts();

        return $this->json($posts);
    }

    public function showUsers()
    {
        $users = $this->adminService->showUsers();

        return $this->json($users);
    }
}
