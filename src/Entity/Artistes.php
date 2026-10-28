<?php

namespace App\Entity;

use App\Repository\ArtistesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistesRepository::class)]
class Artistes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $nationalite = null;

    /**
     * @var Collection<int, Oeuvres>
     */
    #[ORM\ManyToMany(targetEntity: Oeuvres::class, inversedBy: 'Artistes')]
    private Collection $Oeuvres;

    public function __construct()
    {
        $this->Oeuvres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection<int, Oeuvres>
     */
    public function getOeuvres(): Collection
    {
        return $this->Oeuvres;
    }

    public function addOeuvre(Oeuvres $oeuvre): static
    {
        if (!$this->Oeuvres->contains($oeuvre)) {
            $this->Oeuvres->add($oeuvre);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvres $oeuvre): static
    {
        $this->Oeuvres->removeElement($oeuvre);

        return $this;
    }
}
