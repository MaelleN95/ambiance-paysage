<?php

namespace App\Entity;

use App\Repository\BeforeAfterPhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BeforeAfterPhotoRepository::class)]
class BeforeAfterPhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $beforeImage = null;

    #[ORM\Column(length: 255)]
    private ?string $afterImage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $featuredOnHomepage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeforeImage(): ?string
    {
        return $this->beforeImage;
    }

    public function setBeforeImage(string $beforeImage): static
    {
        $this->beforeImage = $beforeImage;

        return $this;
    }

    public function getAfterImage(): ?string
    {
        return $this->afterImage;
    }

    public function setAfterImage(string $afterImage): static
    {
        $this->afterImage = $afterImage;

        return $this;
    }

    public function isFeaturedOnHomepage(): ?bool
    {
        return $this->featuredOnHomepage;
    }

    public function setFeaturedOnHomepage(?bool $featuredOnHomepage): static
    {
        $this->featuredOnHomepage = $featuredOnHomepage;

        return $this;
    }
}
