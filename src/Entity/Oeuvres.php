<?php

namespace App\Entity;

use App\Repository\OeuvresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvresRepository::class)]
class Oeuvres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Artistes>
     */
    #[ORM\ManyToMany(targetEntity: Artistes::class, mappedBy: 'Oeuvres')]
    private Collection $Artistes;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieux $Lieux = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Techniques $technique = null;

    /**
     * @var Collection<int, Photos>
     */
    #[ORM\OneToMany(targetEntity: Photos::class, mappedBy: 'oeuvre')]
    private Collection $photos;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'recouvertePar', cascade: ['persist', 'remove'])]
    private ?self $recouvre = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'recouvre', cascade: ['persist', 'remove'])]
    private ?self $recouvertePar = null;

    public function __construct()
    {
        $this->Artistes = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Artistes>
     */
    public function getArtistes(): Collection
    {
        return $this->Artistes;
    }

    public function addArtiste(Artistes $artiste): static
    {
        if (!$this->Artistes->contains($artiste)) {
            $this->Artistes->add($artiste);
            $artiste->addOeuvre($this);
        }

        return $this;
    }

    public function removeArtiste(Artistes $artiste): static
    {
        if ($this->Artistes->removeElement($artiste)) {
            $artiste->removeOeuvre($this);
        }

        return $this;
    }

    public function getLieux(): ?Lieux
    {
        return $this->Lieux;
    }

    public function setLieux(?Lieux $Lieux): static
    {
        $this->Lieux = $Lieux;

        return $this;
    }

    public function getTechnique(): ?Techniques
    {
        return $this->technique;
    }

    public function setTechnique(?Techniques $technique): static
    {
        $this->technique = $technique;

        return $this;
    }

    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setOeuvre($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getOeuvre() === $this) {
                $photo->setOeuvre(null);
            }
        }

        return $this;
    }

    public function getRecouvre(): ?self
    {
        return $this->recouvre;
    }

    public function setRecouvre(?self $recouvre): static
    {
        $this->recouvre = $recouvre;

        return $this;
    }

    public function getRecouvertePar(): ?self
    {
        return $this->recouvertePar;
    }

    public function setRecouvertePar(?self $recouvertePar): static
    {
        // unset the owning side of the relation if necessary
        if ($recouvertePar === null && $this->recouvertePar !== null) {
            $this->recouvertePar->setRecouvre(null);
        }

        // set the owning side of the relation if necessary
        if ($recouvertePar !== null && $recouvertePar->getRecouvre() !== $this) {
            $recouvertePar->setRecouvre($this);
        }

        $this->recouvertePar = $recouvertePar;

        return $this;
    }
}
