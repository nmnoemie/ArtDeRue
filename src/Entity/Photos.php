<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 30)]
    private ?string $nomFichier = null;

    #[ORM\Column(length: 30)]
    private ?string $etatOeuvre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'photos' , cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Oeuvres $oeuvre = null;

    #[ORM\ManyToOne(inversedBy: 'photos', cascade: ['persist'])] // <-- Ajout de cascade: ['persist']
    #[ORM\JoinColumn(nullable: false)]
    private ?Benevoles $benevole = null;
    
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: 'Veuillez uploader une image valide (JPG, PNG ou WEBP)'
    )]
    private ?File $imageFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): static
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getEtatOeuvre(): ?string
    {
        return $this->etatOeuvre;
    }

    public function setEtatOeuvre(string $etatOeuvre): static
    {
        $this->etatOeuvre = $etatOeuvre;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getOeuvre(): ?Oeuvres
    {
        return $this->oeuvre;
    }

    public function setOeuvre(?Oeuvres $oeuvre): static
    {
        $this->oeuvre = $oeuvre;

        return $this;
    }

    public function getBenevole(): ?Benevoles
    {
        return $this->benevole;
    }

    public function setBenevole(?Benevoles $benevole): static
    {
        $this->benevole = $benevole;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}