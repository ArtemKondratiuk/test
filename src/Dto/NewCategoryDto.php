<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class NewCategoryDto
{
    #[Assert\Type('string')]
    #[Assert\Length(255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
