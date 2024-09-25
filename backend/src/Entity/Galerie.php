<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: GalerieRepository::class)]
class Galerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $documentOriginalName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $documentNewName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $documentType = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $documentUrl = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?bool $showPublic = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?\DateTimeImmutable $cretedAt = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $passwordMedia = null;


    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $documentSize = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'galeries')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentOriginalName(): ?string
    {
        return $this->documentOriginalName;
    }

    public function setDocumentOriginalName(string $documentOriginalName): static
    {
        $this->documentOriginalName = $documentOriginalName;

        return $this;
    }

    public function getDocumentNewName(): ?string
    {
        return $this->documentNewName;
    }

    public function setDocumentNewName(string $documentNewName): static
    {
        $this->documentNewName = $documentNewName;

        return $this;
    }

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getDocumentUrl(): ?string
    {
        return $this->documentUrl;
    }

    public function setDocumentUrl(string $documentUrl): static
    {
        $this->documentUrl = $documentUrl;

        return $this;
    }

    public function isShowPublic(): ?bool
    {
        return $this->showPublic;
    }

    public function setShowPublic(bool $showPublic): static
    {
        $this->showPublic = $showPublic;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getCretedAt(): ?\DateTimeImmutable
    {
        return $this->cretedAt;
    }

    public function setCretedAt(\DateTimeImmutable $cretedAt): static
    {
        $this->cretedAt = $cretedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getPasswordMedia(): ?string
    {
        return $this->passwordMedia;
    }

    public function setPasswordMedia(?string $passwordMedia): static
    {
        $this->passwordMedia = $passwordMedia;

        return $this;
    }

    public function getDocumentSize(): ?int
    {
        return $this->documentSize;
    }

    public function setDocumentSize(int $documentSize): static
    {
        $this->documentSize = $documentSize;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
