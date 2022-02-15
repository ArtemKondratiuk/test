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
    private $text;


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
}
