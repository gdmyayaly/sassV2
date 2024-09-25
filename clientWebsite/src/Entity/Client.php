<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user','viewAdmin'])]
    private ?int $id = null;

    // #[ORM\Column(length: 255)]
    // #[Groups(['list'])]
    // private ?string $name = null;

    // #[ORM\Column(length: 255,unique:true)]
    // #[Groups(['list'])]
    // private ?string $domain = null;

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
    private ?string $domain = null;

    /**
     * @var Collection<int, Site>
     */
    #[ORM\OneToMany(targetEntity: Site::class, mappedBy: 'client')]
    #[Groups(['list'])]
    private Collection $sites;

    /**
     * @var Collection<int, ClientSection>
     */
    #[ORM\OneToMany(targetEntity: ClientSection::class, mappedBy: 'client')]
    private Collection $clientSections;

    /**
     * @var Collection<int, Galerie>
     */
    #[ORM\OneToMany(targetEntity: Galerie::class, mappedBy: 'client')]
    private Collection $galeries;

    /**
     * @var Collection<int, VariationProduct>
     */
    #[ORM\OneToMany(targetEntity: VariationProduct::class, mappedBy: 'client')]
    private Collection $variationProducts;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'client')]
    private Collection $utilisateurs;

    /**
     * @var Collection<int, SocialMediaLink>
     */
    #[ORM\OneToMany(targetEntity: SocialMediaLink::class, mappedBy: 'client')]
    private Collection $socialMediaLinks;

    /**
     * @var Collection<int, CategoryProduct>
     */
    #[ORM\OneToMany(targetEntity: CategoryProduct::class, mappedBy: 'client')]
    private Collection $categoryProducts;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'client')]
    private Collection $products;

    public function __construct()
    {
        $this->createdAt =new DateTimeImmutable('now');
        $this->isActive=true;
        $this->sites = new ArrayCollection();
        $this->clientSections = new ArrayCollection();
        $this->galeries = new ArrayCollection();
        $this->variationProducts = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->socialMediaLinks = new ArrayCollection();
        $this->categoryProducts = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): static
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->setClient($this);
        }

        return $this;
    }

    public function removeSite(Site $site): static
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getClient() === $this) {
                $site->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClientSection>
     */
    public function getClientSections(): Collection
    {
        return $this->clientSections;
    }

    public function addClientSection(ClientSection $clientSection): static
    {
        if (!$this->clientSections->contains($clientSection)) {
            $this->clientSections->add($clientSection);
            $clientSection->setClient($this);
        }

        return $this;
    }

    public function removeClientSection(ClientSection $clientSection): static
    {
        if ($this->clientSections->removeElement($clientSection)) {
            // set the owning side to null (unless already changed)
            if ($clientSection->getClient() === $this) {
                $clientSection->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Galerie>
     */
    public function getGaleries(): Collection
    {
        return $this->galeries;
    }

    public function addGalery(Galerie $galery): static
    {
        if (!$this->galeries->contains($galery)) {
            $this->galeries->add($galery);
            $galery->setClient($this);
        }

        return $this;
    }

    public function removeGalery(Galerie $galery): static
    {
        if ($this->galeries->removeElement($galery)) {
            // set the owning side to null (unless already changed)
            if ($galery->getClient() === $this) {
                $galery->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VariationProduct>
     */
    public function getVariationProducts(): Collection
    {
        return $this->variationProducts;
    }

    public function addVariationProduct(VariationProduct $variationProduct): static
    {
        if (!$this->variationProducts->contains($variationProduct)) {
            $this->variationProducts->add($variationProduct);
            $variationProduct->setClient($this);
        }

        return $this;
    }

    public function removeVariationProduct(VariationProduct $variationProduct): static
    {
        if ($this->variationProducts->removeElement($variationProduct)) {
            // set the owning side to null (unless already changed)
            if ($variationProduct->getClient() === $this) {
                $variationProduct->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setClient($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getClient() === $this) {
                $utilisateur->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SocialMediaLink>
     */
    public function getSocialMediaLinks(): Collection
    {
        return $this->socialMediaLinks;
    }

    public function addSocialMediaLink(SocialMediaLink $socialMediaLink): static
    {
        if (!$this->socialMediaLinks->contains($socialMediaLink)) {
            $this->socialMediaLinks->add($socialMediaLink);
            $socialMediaLink->setClient($this);
        }

        return $this;
    }

    public function removeSocialMediaLink(SocialMediaLink $socialMediaLink): static
    {
        if ($this->socialMediaLinks->removeElement($socialMediaLink)) {
            // set the owning side to null (unless already changed)
            if ($socialMediaLink->getClient() === $this) {
                $socialMediaLink->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryProduct>
     */
    public function getCategoryProducts(): Collection
    {
        return $this->categoryProducts;
    }

    public function addCategoryProduct(CategoryProduct $categoryProduct): static
    {
        if (!$this->categoryProducts->contains($categoryProduct)) {
            $this->categoryProducts->add($categoryProduct);
            $categoryProduct->setClient($this);
        }

        return $this;
    }

    public function removeCategoryProduct(CategoryProduct $categoryProduct): static
    {
        if ($this->categoryProducts->removeElement($categoryProduct)) {
            // set the owning side to null (unless already changed)
            if ($categoryProduct->getClient() === $this) {
                $categoryProduct->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setClient($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getClient() === $this) {
                $product->setClient(null);
            }
        }

        return $this;
    }
}
