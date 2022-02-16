<?php

namespace App\Controller;

use App\Dto\NewUserDto;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {}

    public function registration(Request $request): JsonResponse
    {

        $newUserDto = new NewUserDto();
        $newUserDto->username = $request->get('username');
        $newUserDto->email = $request->get('email');
        $newUserDto->password = $request->get('password');

        $this->validator->validate($newUserDto);
        $this->userRepository->newUser($newUserDto);

        return $this->json($newUserDto);
    }
}
