<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column]
    private ?int $limitePlace = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apercu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $tri = null;

    #[ORM\Column]
    private ?bool $miseEnAvant = null;

    // ----- Relation ManyToOne avec TypeSalle -----
    #[ORM\ManyToOne(inversedBy: 'salles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeSalle $typeSalle = null;

    public function __construct()
    {
        $this->status = true;
        $this->miseEnAvant = false;
    }

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function getLimitePlace(): ?int
    {
        return $this->limitePlace;
    }

    public function setLimitePlace(int $limitePlace): static
    {
        $this->limitePlace = $limitePlace;
        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getApercu(): ?string
    {
        return $this->apercu;
    }

    public function setApercu(?string $apercu): static
    {
        $this->apercu = $apercu;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getTri(): ?int
    {
        return $this->tri;
    }

    public function setTri(int $tri): static
    {
        $this->tri = $tri;
        return $this;
    }

    public function isMiseEnAvant(): ?bool
    {
        return $this->miseEnAvant;
    }

    public function setMiseEnAvant(bool $miseEnAvant): static
    {
        $this->miseEnAvant = $miseEnAvant;
        return $this;
    }

    public function getTypeSalle(): ?TypeSalle
    {
        return $this->typeSalle;
    }

    public function setTypeSalle(?TypeSalle $typeSalle): static
    {
        $this->typeSalle = $typeSalle;
        return $this;
    }
}