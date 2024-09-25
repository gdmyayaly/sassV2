<?php

namespace App\Entity;

use App\Repository\SocialMediaLinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SocialMediaLinkRepository::class)]
class SocialMediaLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $numero = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $homemessage = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $shopmessage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $snapchat = null;

    #[ORM\ManyToOne(inversedBy: 'socialMediaLinks')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getHomemessage(): ?string
    {
        return $this->homemessage;
    }

    public function setHomemessage(string $homemessage): static
    {
        $this->homemessage = $homemessage;

        return $this;
    }

    public function getShopmessage(): ?string
    {
        return $this->shopmessage;
    }

    public function setShopmessage(string $shopmessage): static
    {
        $this->shopmessage = $shopmessage;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getSnapchat(): ?string
    {
        return $this->snapchat;
    }

    public function setSnapchat(?string $snapchat): static
    {
        $this->snapchat = $snapchat;

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
