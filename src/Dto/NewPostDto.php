<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewPostDto
{

    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private $title;

    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private $content;


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
}
