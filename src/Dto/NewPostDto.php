<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewPostDto
{
    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public $title;

    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public $text;
}
