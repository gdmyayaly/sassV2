<?php

namespace App\Entity;

use App\Repository\SousCategoryProductRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: SousCategoryProductRepository::class)]
class SousCategoryProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list','listProduct'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','listProduct'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','listProduct'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','listProduct'])]
    private ?string $image = null;
    
    #[ORM\Column]
    #[Groups(['list','listProduct'])]
    private ?\DateTimeImmutable $creteadAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','listProduct'])]
    private ?string $slug = null;

    // #[ORM\ManyToOne(inversedBy: 'sousCategoryProducts')]
    // private ?CategoryProduct $category = null;

    #[ORM\Column(nullable: true)]
    private ?int $oldCategory = null;

    #[ORM\ManyToOne(inversedBy: 'sousCategoryProducts')]
    private ?CategoryProduct $category = null;

    /**
     * @var Collection<int, ProductCategoryValue>
     */
    #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'sousCategory')]
    private Collection $productCategoryValues;

    // #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'sousCategory')]
    // private Collection $productCategoryValues;
    
    public function __construct()
    {
        $this->creteadAt= new DateTimeImmutable('now');
        $this->deletedAt= new DateTimeImmutable('now');
        $this->isDeleted= false;
        $this->oldCategory=null;
        $this->productCategoryValues = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
    public function getCreteadAt(): ?\DateTimeImmutable
    {
        return $this->creteadAt;
    }

    public function setCreteadAt(\DateTimeImmutable $creteadAt): static
    {
        $this->creteadAt = $creteadAt;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getCategory(): ?CategoryProduct
    {
        return $this->category;
    }

    public function setCategory(?CategoryProduct $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategoryValue>
     */
    public function getProductCategoryValues(): Collection
    {
        return $this->productCategoryValues;
    }

    public function addProductCategoryValue(ProductCategoryValue $productCategoryValue): static
    {
        if (!$this->productCategoryValues->contains($productCategoryValue)) {
            $this->productCategoryValues->add($productCategoryValue);
            $productCategoryValue->setSousCategory($this);
        }

        return $this;
    }

    public function removeProductCategoryValue(ProductCategoryValue $productCategoryValue): static
    {
        if ($this->productCategoryValues->removeElement($productCategoryValue)) {
            // set the owning side to null (unless already changed)
            if ($productCategoryValue->getSousCategory() === $this) {
                $productCategoryValue->setSousCategory(null);
            }
        }

        return $this;
    }

    
}
