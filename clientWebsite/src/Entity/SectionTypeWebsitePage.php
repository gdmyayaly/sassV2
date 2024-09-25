<?php

namespace App\Entity;

use App\Repository\SectionTypeWebsitePageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectionTypeWebsitePageRepository::class)]
class SectionTypeWebsitePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['viewAdmin','listSelection'])]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Groups(['viewAdmin','listSelection'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['viewAdmin','listSelection'])]
    private ?string $description = null;

    #[Groups(['viewAdmin','listSelection'])]
    private ?int $count = null;
    #[ORM\Column(length: 255)]
    #[Groups(['viewAdmin','listSelection'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, Section>
     */
    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'sectionType')]
    private Collection $sections;

    #[ORM\Column]
    private ?bool $isCommon = null;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->isCommon=false;
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
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setSectionType($this);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getSectionType() === $this) {
                $section->setSectionType(null);
            }
        }

        return $this;
    }
    public function getCount(): ?int
    {
        return count($this->getSections());
    }

    public function isCommon(): ?bool
    {
        return $this->isCommon;
    }

    public function setCommon(bool $isCommon): static
    {
        $this->isCommon = $isCommon;

        return $this;
    }
}
