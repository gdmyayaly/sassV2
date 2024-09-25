<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $type = null;

    /**
     * @var Collection<int, ClientSection>
     */
    #[ORM\OneToMany(targetEntity: ClientSection::class, mappedBy: 'section')]
    private Collection $clientSections;

    /**
     * @var Collection<int, SiteSection>
     */
    #[ORM\OneToMany(targetEntity: SiteSection::class, mappedBy: 'section')]
    private Collection $siteSections;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    #[Groups(['list'])]
    private ?SectionTypeWebsitePage $sectionType = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $urlPreview = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $css = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $js = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    public function __construct()
    {
        $this->clientSections = new ArrayCollection();
        $this->siteSections = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable('now');
        $this->isDeleted= false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
            $clientSection->setSection($this);
        }

        return $this;
    }

    public function removeClientSection(ClientSection $clientSection): static
    {
        if ($this->clientSections->removeElement($clientSection)) {
            // set the owning side to null (unless already changed)
            if ($clientSection->getSection() === $this) {
                $clientSection->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SiteSection>
     */
    public function getSiteSections(): Collection
    {
        return $this->siteSections;
    }

    public function addSiteSection(SiteSection $siteSection): static
    {
        if (!$this->siteSections->contains($siteSection)) {
            $this->siteSections->add($siteSection);
            $siteSection->setSection($this);
        }

        return $this;
    }

    public function removeSiteSection(SiteSection $siteSection): static
    {
        if ($this->siteSections->removeElement($siteSection)) {
            // set the owning side to null (unless already changed)
            if ($siteSection->getSection() === $this) {
                $siteSection->setSection(null);
            }
        }

        return $this;
    }

    public function getSectionType(): ?SectionTypeWebsitePage
    {
        return $this->sectionType;
    }

    public function setSectionType(?SectionTypeWebsitePage $sectionType): static
    {
        $this->sectionType = $sectionType;

        return $this;
    }

    public function getUrlPreview(): ?string
    {
        return $this->urlPreview;
    }

    public function setUrlPreview(string $urlPreview): static
    {
        $this->urlPreview = $urlPreview;

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

    public function getCss(): ?string
    {
        return $this->css;
    }

    public function setCss(string $css): static
    {
        $this->css = $css;

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

    public function getJs(): ?string
    {
        return $this->js;
    }

    public function setJs(?string $js): static
    {
        $this->js = $js;

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

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

   
}
