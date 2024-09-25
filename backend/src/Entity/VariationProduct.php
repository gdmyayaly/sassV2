<?php

namespace App\Entity;

use App\Repository\VariationProductRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VariationProductRepository::class)]
class VariationProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list','listProduct'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','listProduct'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['list','listProduct'])]
    private array $valeur = [];

    #[ORM\Column]
    #[Groups(['list','listProduct'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\OneToMany(targetEntity: ProductVariationValue::class, mappedBy: 'variationProduct')]
    private Collection $productVariationValues;

    #[ORM\ManyToOne(inversedBy: 'variationProducts')]
    private ?Client $client = null;

    public function __construct()
    {
        $this->productVariationValues = new ArrayCollection();
        $this->createdAt =new DateTimeImmutable('now');
        $this->deletedAt =new DateTimeImmutable('now');
        $this->isDeleted=false;
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

    public function getValeur(): array
    {
        return $this->valeur;
    }

    public function setValeur(array $valeur): static
    {
        $this->valeur = $valeur;

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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

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

    /**
     * @return Collection<int, ProductVariationValue>
     */
    public function getProductVariationValues(): Collection
    {
        return $this->productVariationValues;
    }

    public function addProductVariationValue(ProductVariationValue $productVariationValue): static
    {
        if (!$this->productVariationValues->contains($productVariationValue)) {
            $this->productVariationValues->add($productVariationValue);
            $productVariationValue->setVariationProduct($this);
        }

        return $this;
    }

    public function removeProductVariationValue(ProductVariationValue $productVariationValue): static
    {
        if ($this->productVariationValues->removeElement($productVariationValue)) {
            // set the owning side to null (unless already changed)
            if ($productVariationValue->getVariationProduct() === $this) {
                $productVariationValue->setVariationProduct(null);
            }
        }

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
