<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostController;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'show_post' => [
            'route_name' => 'show_post',
            'method' => 'GET',
            'path' => '/posts',
            'controller' => PostController::class,
        ],
    ],
    itemOperations: [
        'show_post_by_id' => [
            'route_name' => 'show_post_by_id',
            'method' => 'GET',
            'path' => '/post/{id}',
            'controller' => PostController::class,
        ],
        'new_post' => [
            'route_name' => 'new_post',
            'method' => 'POST',
            'path' => '/post/new',
            'controller' => PostController::class,
        ],
        'edit_post' => [
            'route_name' => 'edit_post',
            'method' => 'POST',
            'path' => '/edit/{post}',
            'controller' => PostController::class,
        ],
        'remove_post' => [
            'route_name' => 'remove_post',
            'method' => 'DELETE',
            'path' => '/remove/{post}',
            'controller' => PostController::class,
        ],
    ],
    normalizationContext: [
        'groups' => [
            'get',
        ]
    ]
)]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Groups('get')]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Groups('get')]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('get')]
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
