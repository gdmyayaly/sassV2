<?php

namespace App\Entity;

use App\Repository\ProductCategoryValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductCategoryValueRepository::class)]
class ProductCategoryValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['listProduct'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productCategoryValues')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productCategoryValues')]
    #[Groups(['listProduct'])]
    private ?CategoryProduct $category = null;

    #[ORM\ManyToOne(inversedBy: 'productCategoryValues')]
    #[Groups(['listProduct'])]
    private ?SousCategoryProduct $sousCategory = null;

    #[ORM\Column(nullable: true)]
    private ?int $oldCategory = null;

    #[ORM\Column(nullable: true)]
    private ?int $oldSousCategory = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?CategoryProduct
    {
        return $this->category;
    }

    public function setCategory(?CategoryProduct $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSousCategory(): ?SousCategoryProduct
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?SousCategoryProduct $sousCategory): static
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    public function getOldCategory(): ?int
    {
        return $this->oldCategory;
    }

    public function setOldCategory(?int $oldCategory): static
    {
        $this->oldCategory = $oldCategory;

        return $this;
    }

    public function getOldSousCategory(): ?int
    {
        return $this->oldSousCategory;
    }

    public function setOldSousCategory(?int $oldSousCategory): static
    {
        $this->oldSousCategory = $oldSousCategory;

        return $this;
    }
}
