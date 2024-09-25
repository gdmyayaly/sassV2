<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sites')]
    private ?Client $client = null;

    #[ORM\Column]
    #[Groups(['site'])]
    private ?bool $isPublished = null;

    #[ORM\Column(length: 255)]
    #[Groups(['site'])]
    private ?string $pageName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['site'])]

    private ?string $url = null;

    /**
     * @var Collection<int, SiteSection>
     */
    #[ORM\OneToMany(targetEntity: SiteSection::class, mappedBy: 'site')]
    private Collection $siteSections;

    

    public function __construct()
    {
        $this->siteSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPageName(): ?string
    {
        return $this->pageName;
    }

    public function setPageName(string $pageName): static
    {
        $this->pageName = $pageName;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

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
            $siteSection->setSite($this);
        }

        return $this;
    }

    public function removeSiteSection(SiteSection $siteSection): static
    {
        if ($this->siteSections->removeElement($siteSection)) {
            // set the owning side to null (unless already changed)
            if ($siteSection->getSite() === $this) {
                $siteSection->setSite(null);
            }
        }

        return $this;
    }

   
}
