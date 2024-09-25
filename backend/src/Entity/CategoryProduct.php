<?php

namespace App\Entity;

use App\Repository\CategoryProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryProductRepository::class)]
class CategoryProduct
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

    // #[ORM\ManyToOne(inversedBy: 'categoryProducts')]
    // private ?ConfigEntreprise $entreprise = null;

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

    #[ORM\ManyToOne(inversedBy: 'categoryProducts')]
    private ?Client $client = null;

    /**
     * @var Collection<int, SousCategoryProduct>
     */
    #[ORM\OneToMany(targetEntity: SousCategoryProduct::class, mappedBy: 'category')]
    #[Groups(['list'])]
    private Collection $sousCategoryProducts;

    /**
     * @var Collection<int, ProductCategoryValue>
     */
    #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'category')]
    private Collection $productCategoryValues;

    // #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'category')]
    // // #[Groups(['product'])]
    // private Collection $productCategoryValues;

    // #[ORM\OneToMany(targetEntity: SousCategoryProduct::class, mappedBy: 'category')]
    // #[Groups(['list'])]
    // private Collection $sousCategoryProducts;

    public function __construct()
    {
        $this->sousCategoryProducts = new ArrayCollection();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, SousCategoryProduct>
     */
    public function getSousCategoryProducts(): Collection
    {
        return $this->sousCategoryProducts;
    }

    public function addSousCategoryProduct(SousCategoryProduct $sousCategoryProduct): static
    {
        if (!$this->sousCategoryProducts->contains($sousCategoryProduct)) {
            $this->sousCategoryProducts->add($sousCategoryProduct);
            $sousCategoryProduct->setCategory($this);
        }

        return $this;
    }

    public function removeSousCategoryProduct(SousCategoryProduct $sousCategoryProduct): static
    {
        if ($this->sousCategoryProducts->removeElement($sousCategoryProduct)) {
            // set the owning side to null (unless already changed)
            if ($sousCategoryProduct->getCategory() === $this) {
                $sousCategoryProduct->setCategory(null);
            }
        }

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
            $productCategoryValue->setCategory($this);
        }

        return $this;
    }

    public function removeProductCategoryValue(ProductCategoryValue $productCategoryValue): static
    {
        if ($this->productCategoryValues->removeElement($productCategoryValue)) {
            // set the owning side to null (unless already changed)
            if ($productCategoryValue->getCategory() === $this) {
                $productCategoryValue->setCategory(null);
            }
        }

        return $this;
    }

  
}
