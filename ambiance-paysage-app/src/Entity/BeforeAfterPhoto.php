<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BeforeAfterPhotoRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BeforeAfterPhotoRepository::class)]
class BeforeAfterPhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $beforeImage = null;

    #[Vich\UploadableField(mapping: "before_after_photo", fileNameProperty: "beforeImage")]
    #[Assert\File(
        maxSize: '15M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: "Veuillez uploader une image valide (jpg, png ou webp)."
    )]
    private ?File $beforeImageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $afterImage = null;

    #[Vich\UploadableField(mapping: "before_after_photo", fileNameProperty: "afterImage")]
    #[Assert\File(
        maxSize: '15M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: "Veuillez uploader une image valide (jpg, png ou webp)."
    )]
    private ?File $afterImageFile = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeforeImage(): ?string
    {
        return $this->beforeImage ?? null;
    }

    public function setBeforeImage(?string $beforeImage): static
    {
        $this->beforeImage = $beforeImage;

        return $this;
    }

    public function getAfterImage(): ?string
    {
        return $this->afterImage ?? null;
    }

    public function setAfterImage(?string $afterImage): static
    {
        $this->afterImage = $afterImage;

        return $this;
    }

    public function setBeforeImageFile(?File $file = null): void
    {
        $this->beforeImageFile = $file;
        if ($file) $this->updatedAt = new \DateTimeImmutable();
    }

    public function getBeforeImageFile(): ?File
    {
        return $this->beforeImageFile;
    }

    public function setAfterImageFile(?File $file = null): void
    {
        $this->afterImageFile = $file;
        if ($file) $this->updatedAt = new \DateTimeImmutable();
    }

    public function getAfterImageFile(): ?File
    {
        return $this->afterImageFile;
    }
}
