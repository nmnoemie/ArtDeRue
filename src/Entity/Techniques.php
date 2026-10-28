<?php

namespace App\Entity;

use App\Repository\TechniquesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechniquesRepository::class)]
class Techniques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $technique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechnique(): ?string
    {
        return $this->technique;
    }

    public function setTechnique(string $technique): static
    {
        $this->technique = $technique;

        return $this;
    }
}
