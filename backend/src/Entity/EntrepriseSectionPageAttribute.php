<?php

namespace App\Entity;

use App\Repository\EntrepriseSectionPageAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseSectionPageAttributeRepository::class)]
class EntrepriseSectionPageAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
