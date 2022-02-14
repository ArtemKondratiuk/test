<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewUserDto
{
    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private $username;

    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    #[Assert\Type('string')]
    #[Assert\Length(180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\-_=+{}|?>.<,:;~`']{8,}$/",
        message: 'This password has unprocessable  symbols or less than 8 symbols'
    )]
    private $password;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }
}
