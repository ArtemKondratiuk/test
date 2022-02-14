<?php

namespace App\Controller;

use App\Dto\NewUserDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    public function __construct(
        public UserService $userService,
        public ValidatorInterface $validator
    ) {}

    public function registration(Request $request)
    {

        $newUserDto = new NewUserDto();
        $newUserDto->setUsername(json_decode($request->getContent(), true)['username'])
                ->setEmail(json_decode($request->getContent(), true)['email'])
                ->setPassword(json_decode($request->getContent(), true)['password'])
        ;

        $this->validator->validate($newUserDto);
        $this->userService->newUser($newUserDto);

        return $this->json($newUserDto);
    }
}
