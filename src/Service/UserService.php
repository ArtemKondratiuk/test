<?php

namespace App\Service;

use App\Dto\NewUserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        public UserPasswordHasherInterface $passwordHasher,
        public EntityManagerInterface $em
    ) {}

    public function newUser(NewUserDto $newUserDto)
    {
        $user = new User();
        $user->setPassword($this->passwordHasher->hashPassword($user, (string)$newUserDto->getPassword()))
            ->setEmail($newUserDto->getEmail())
            ->setUsername($newUserDto->getUsername())
            ->setRoles(["ROLE_USER"]);

        $this->em->persist($user);
        $this->em->flush();
    }
}
