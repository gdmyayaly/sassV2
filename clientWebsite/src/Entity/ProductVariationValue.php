<?php

namespace App\Entity;

use App\Repository\ProductVariationValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductVariationValueRepository::class)]
class ProductVariationValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['listProduct'])]
    private ?int $id = null;

    // #[ORM\ManyToOne(inversedBy: 'productVariationValues')]
    // private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productVariationValues')]
    #[Groups(['listProduct'])]
    private ?VariationProduct $variationProduct = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['listProduct'])]
    private array $value = [];

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\ManyToOne(inversedBy: 'productVariationValues')]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getProduct(): ?Product
    // {
    //     return $this->product;
    // }

    // public function setProduct(?Product $product): static
    // {
    //     $this->product = $product;

    //     return $this;
    // }

    public function getVariationProduct(): ?VariationProduct
    {
        return $this->variationProduct;
    }

    public function setVariationProduct(?VariationProduct $variationProduct): static
    {
        $this->variationProduct = $variationProduct;

        return $this;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): static
    {
        $this->value = $value;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
