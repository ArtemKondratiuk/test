<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AdminController;
use App\Controller\PostController;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ApiResource(
    collectionOperations: [
        'show_post' => [
            'route_name' => 'show_post',
            'method' => 'GET',
            'path' => '/posts',
            'controller' => PostController::class,
        ],
        'admin_show_posts' => [
            'route_name' => 'admin_show_posts',
            'method' => 'GET',
            'path' => '/admin/posts',
            'controller' => AdminController::class,
        ],
        'new_post' => [
            'route_name' => 'new_post',
            'method' => 'POST',
            'path' => '/post/new',
            'controller' => PostController::class,
            'openapi_context' => [
                'requestBody' => [
                    'description' => 'New Post',
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'title' => [
                                        'type' => 'string',
                                        'description' => 'add title'
                                    ],
                                     'text' => [
                                         'type' => 'string',
                                         'description' => 'add text'
                                     ],
                                     'category' => [
                                         'type' => 'string',
                                         'description' => 'add category'
                                     ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    itemOperations: [
        'show_post_by_id' => [
            'route_name' => 'show_post_by_id',
            'method' => 'GET',
            'path' => '/post/{id}',
            'controller' => PostController::class,
        ],
        'edit_post' => [
            'route_name' => 'edit_post',
            'method' => 'POST',
            'path' => '/edit/{post}',
            'controller' => PostController::class,
            'openapi_context' => [
                'requestBody' => [
                    'description' => 'Edit Post',
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'title' => [
                                        'type' => 'string',
                                        'description' => 'edit title'
                                    ],
                                     'text' => [
                                         'type' => 'string',
                                         'description' => 'edit text'
                                    ],
                                     'category' => [
                                         'type' => 'string',
                                         'description' => 'edit category'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
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
    private $text;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('get')]
    private $author;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts', cascade: ['persist'])]
    private Collection $categories;

    #[Pure] public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    public function addCategory(Category ...$categories): void
    {
        foreach ($categories as $category) {
            if (!$this->categories->contains($category)) {
                $this->categories->add($category);
            }
        }
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }
}
