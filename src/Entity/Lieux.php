<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuxRepository::class)]
class Lieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    private ?string $quartier = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $GPS = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getGPS(): ?string
    {
        return $this->GPS;
    }

    public function setGPS(string $GPS): static
    {
        $this->GPS = $GPS;

        return $this;
    }
}
