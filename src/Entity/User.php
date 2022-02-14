<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => [],
        'registration' => [
            'route_name' => 'registration',
            'method' => 'POST',
            'path' => '/user/registration',
            'controller' => UserController::class,
        ],
    ],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('get')]
    private $id;

    #[ORM\Column(type: 'string', length: 180)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Groups('get')]
    private $username;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups('get')]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups('get')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups('get')]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\-_=+{}|?>.<,:;~`']{8,}$/",
        message: 'This password has unprocessable  symbols or less than 8 symbols'
    )]
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
