<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewUserDto
{
    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public $username;

    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    public $email;

    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\-_=+{}|?>.<,:;~`']{8,}$/",
        message: 'This password has unprocessable  symbols or less than 8 symbols'
    )]
    public $password;
}
