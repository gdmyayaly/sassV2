<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
     #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['listProduct'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listProduct'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listProduct'])]
    private ?string $brefDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['listProduct'])]
    private ?string $detailDescription = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listProduct'])]
    private ?string $image = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['listProduct'])]
    private ?array $otherImage = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['listProduct'])]
    private ?array $otherVideo = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['listProduct'])]
    private ?int $prix = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['listProduct'])]
    private ?int $prixPromo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['listProduct'])]
    private ?\DateTimeInterface $promoStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['listProduct'])]
    private ?\DateTimeInterface $promoEnd = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['listProduct'])]
    private ?array $colors = null;

    #[ORM\Column]
    #[Groups(['listProduct'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    // #[ORM\OneToMany(targetEntity: ProductVariationValue::class, mappedBy: 'product')]
    // #[Groups(['listProduct'])]
    // private Collection $productVariationValues;

    // #[ORM\ManyToOne(inversedBy: 'products')]
    // private ?ConfigEntreprise $entreprise = null;

    // #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'product')]
    // #[Groups(['listProduct'])]
    // private Collection $productCategoryValues;

    #[ORM\Column(nullable: true)]
    #[Groups(['listProduct'])]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listProduct'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, ProductCategoryValue>
     */
    #[ORM\OneToMany(targetEntity: ProductCategoryValue::class, mappedBy: 'product')]
    #[Groups(['listProduct'])]
    private Collection $productCategoryValues;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Client $client = null;

    /**
     * @var Collection<int, ProductVariationValue>
     */
    #[ORM\OneToMany(targetEntity: ProductVariationValue::class, mappedBy: 'product')]
    #[Groups(['listProduct'])]
    private Collection $productVariationValues;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now');
        $this->deletedAt = new DateTimeImmutable('now');
        $this->setIsDeleted(false);
        $this->productCategoryValues = new ArrayCollection();
        $this->productVariationValues = new ArrayCollection();
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

    public function getBrefDescription(): ?string
    {
        return $this->brefDescription;
    }

    public function setBrefDescription(string $brefDescription): static
    {
        $this->brefDescription = $brefDescription;

        return $this;
    }

    public function getDetailDescription(): ?string
    {
        return $this->detailDescription;
    }

    public function setDetailDescription(?string $detailDescription): static
    {
        if ($detailDescription=="") {
            $this->detailDescription = null;
        }
        else{
            $this->detailDescription = $detailDescription;
        }
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOtherImage(): ?array
    {
        return $this->otherImage;
    }

    public function setOtherImage(?array $otherImage): static
    {
        $this->otherImage = $otherImage;

        return $this;
    }
    public function getOtherVideo(): ?array
    {
        return $this->otherVideo;
    }

    public function setOtherVideo(?array $otherVideo): static
    {
        $this->otherVideo = $otherVideo;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {  
        if ($prix=="") {
            $this->prix = null;

        } else {
            $this->prix = $prix;

        }
        return $this;
    }

    public function getPrixPromo(): ?int
    {
        return $this->prixPromo;
    }

    public function setPrixPromo(?int $prixPromo): static
    {
        if ($prixPromo=="") {
            $this->prixPromo = null;

        } else {
            $this->prixPromo = $prixPromo;

        }
        return $this;
    }

    public function getPromoStart(): ?\DateTimeInterface
    {
        return $this->promoStart;
    }

    public function setPromoStart(?\DateTimeInterface $promoStart): static
    {
        if ($promoStart=="") {
            $this->promoStart = null;

        } else {
            $this->promoStart = $promoStart;

        }

        return $this;
    }

    public function getPromoEnd(): ?\DateTimeInterface
    {
        return $this->promoEnd;
    }

    public function setPromoEnd(?\DateTimeInterface $promoEnd): static
    {
        if ($promoEnd=="") {
            $this->promoEnd = null;

        } else {
            $this->promoEnd = $promoEnd;

        }
        return $this;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColors(?array $colors): static
    {
        $this->colors = $colors;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

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
            $productCategoryValue->setProduct($this);
        }

        return $this;
    }

    public function removeProductCategoryValue(ProductCategoryValue $productCategoryValue): static
    {
        if ($this->productCategoryValues->removeElement($productCategoryValue)) {
            // set the owning side to null (unless already changed)
            if ($productCategoryValue->getProduct() === $this) {
                $productCategoryValue->setProduct(null);
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
            $productVariationValue->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariationValue(ProductVariationValue $productVariationValue): static
    {
        if ($this->productVariationValues->removeElement($productVariationValue)) {
            // set the owning side to null (unless already changed)
            if ($productVariationValue->getProduct() === $this) {
                $productVariationValue->setProduct(null);
            }
        }

        return $this;
    }
}
