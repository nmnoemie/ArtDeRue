<?php

namespace App\Entity;

use App\Repository\TechniquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Oeuvres>
     */
    #[ORM\OneToMany(targetEntity: Oeuvres::class, mappedBy: 'technique')]
    private Collection $oeuvres;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Oeuvres>
     */
    public function getOeuvres(): Collection
    {
        return $this->oeuvres;
    }

    public function addOeuvre(Oeuvres $oeuvre): static
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres->add($oeuvre);
            $oeuvre->setTechnique($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvres $oeuvre): static
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getTechnique() === $this) {
                $oeuvre->setTechnique(null);
            }
        }

        return $this;
    }
}
