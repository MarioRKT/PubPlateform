<?php

namespace App\Entity;

use App\Repository\SiteConfigRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteConfigRepository::class)]
class SiteConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titrePage = null;

    #[ORM\Column(length: 255)]
    private ?string $copyright = null;

    #[ORM\Column(length: 255)]
    private ?string $lienSiteWeb = null;

    #[ORM\Column]
    private ?bool $activationPaiement = null;

    #[ORM\Column]
    private ?int $nbrMaxMenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $favicon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePage(): ?string
    {
        return $this->titrePage;
    }

    public function setTitrePage(string $titrePage): static
    {
        $this->titrePage = $titrePage;

        return $this;
    }

    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    public function setCopyright(string $copyright): static
    {
        $this->copyright = $copyright;

        return $this;
    }

    public function getLienSiteWeb(): ?string
    {
        return $this->lienSiteWeb;
    }

    public function setLienSiteWeb(string $lienSiteWeb): static
    {
        $this->lienSiteWeb = $lienSiteWeb;

        return $this;
    }

    public function isActivationPaiement(): ?bool
    {
        return $this->activationPaiement;
    }

    public function setActivationPaiement(bool $activationPaiement): static
    {
        $this->activationPaiement = $activationPaiement;

        return $this;
    }

    public function getNbrMaxMenu(): ?int
    {
        return $this->nbrMaxMenu;
    }

    public function setNbrMaxMenu(int $nbrMaxMenu): static
    {
        $this->nbrMaxMenu = $nbrMaxMenu;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getFavicon(): ?string
    {
        return $this->favicon;
    }

    public function setFavicon(?string $favicon): static
    {
        $this->favicon = $favicon;

        return $this;
    }
}
