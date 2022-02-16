<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewCategoryDto extends \App\Entity\Post
{
    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public $name;
}
