<?php

namespace App\Entity;

use App\Repository\FractionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FractionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Fraction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fraction_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fraction_description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_modified = null;

    public function __construct()
    {
        $this->date_created = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function updateDateModified(): void
    {
        $this->date_modified = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFractionName(): ?string
    {
        return $this->fraction_name;
    }

    public function setFractionName(string $fraction_name): static
    {
        $this->fraction_name = $fraction_name;

        return $this;
    }

    public function getFractionDescription(): ?string
    {
        return $this->fraction_description;
    }

    public function setFractionDescription(?string $fraction_description): static
    {
        $this->fraction_description = $fraction_description;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): static
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->date_modified;
    }

    public function setDateModified(?\DateTimeInterface $date_modified): static
    {
        $this->date_modified = $date_modified;

        return $this;
    }
}
