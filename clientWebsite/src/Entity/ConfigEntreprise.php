<?php

namespace App\Entity;

use App\Repository\ConfigEntrepriseRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ConfigEntrepriseRepository::class)]
class ConfigEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user','viewAdmin'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user','viewAdmin'])]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user','viewAdmin'])]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user','viewAdmin'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user','viewAdmin'])]
    private ?string $telephoneRepresentant = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user','viewAdmin'])]
    private ?string $emailEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user','viewAdmin'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user','viewAdmin'])]
    private ?string $websiteType = null;

    #[ORM\Column]
    #[Groups(['user','viewAdmin'])]
    private ?int $galerieSizeLimit = null;

    #[ORM\Column]
    #[Groups(['user','viewAdmin'])]
    private ?int $galerieSizeActuel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['user','viewAdmin'])]
    private ?\DateTimeInterface $dateDebutAbonnement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['user','viewAdmin'])]
    private ?\DateTimeInterface $dateFinAbonnement = null;

    #[ORM\Column]
    #[Groups(['viewAdmin'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['user','viewAdmin'])]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user','viewAdmin'])]
    private ?string $linkWebsite = null;

    public function __construct()
    {
        $this->createdAt =new DateTimeImmutable('now');
        $this->isActive=true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

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

    public function getTelephoneRepresentant(): ?string
    {
        return $this->telephoneRepresentant;
    }

    public function setTelephoneRepresentant(string $telephoneRepresentant): static
    {
        $this->telephoneRepresentant = $telephoneRepresentant;

        return $this;
    }

    public function getEmailEntreprise(): ?string
    {
        return $this->emailEntreprise;
    }

    public function setEmailEntreprise(?string $emailEntreprise): static
    {
        $this->emailEntreprise = $emailEntreprise;

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

    public function getWebsiteType(): ?string
    {
        return $this->websiteType;
    }

    public function setWebsiteType(string $websiteType): static
    {
        $this->websiteType = $websiteType;

        return $this;
    }

    public function getGalerieSizeLimit(): ?int
    {
        return $this->galerieSizeLimit;
    }

    public function setGalerieSizeLimit(int $galerieSizeLimit): static
    {
        $this->galerieSizeLimit = $galerieSizeLimit;

        return $this;
    }

    public function getGalerieSizeActuel(): ?int
    {
        return $this->galerieSizeActuel;
    }

    public function setGalerieSizeActuel(int $galerieSizeActuel): static
    {
        $this->galerieSizeActuel = $galerieSizeActuel;

        return $this;
    }

    public function getDateDebutAbonnement(): ?\DateTimeInterface
    {
        return $this->dateDebutAbonnement;
    }

    public function setDateDebutAbonnement(\DateTimeInterface $dateDebutAbonnement): static
    {
        $this->dateDebutAbonnement = $dateDebutAbonnement;

        return $this;
    }

    public function getDateFinAbonnement(): ?\DateTimeInterface
    {
        return $this->dateFinAbonnement;
    }

    public function setDateFinAbonnement(\DateTimeInterface $dateFinAbonnement): static
    {
        $this->dateFinAbonnement = $dateFinAbonnement;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getLinkWebsite(): ?string
    {
        return $this->linkWebsite;
    }

    public function setLinkWebsite(string $linkWebsite): static
    {
        $this->linkWebsite = $linkWebsite;

        return $this;
    }

}
