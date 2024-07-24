<?php

namespace App\Entity;

use App\Repository\ShperaczeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShperaczeRepository::class)]
class Shperacze
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nickname = null;

    #[ORM\Column(nullable: true)]
    private ?int $shper_number = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_modified = null;

    #[ORM\Column]
    private ?bool $active = null;

    /**
     * @var Collection<int, ScannedObject>
     */
    #[ORM\OneToMany(targetEntity: ScannedObject::class, mappedBy: 'shper_id')]
    private Collection $scannedObjects;

    public function __construct()
    {
        $this->scannedObjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getShperNumber(): ?int
    {
        return $this->shper_number;
    }

    public function setShperNumber(?int $shper_number): static
    {
        $this->shper_number = $shper_number;

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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, ScannedObject>
     */
    public function getScannedObjects(): Collection
    {
        return $this->scannedObjects;
    }

    public function addScannedObject(ScannedObject $scannedObject): static
    {
        if (!$this->scannedObjects->contains($scannedObject)) {
            $this->scannedObjects->add($scannedObject);
            $scannedObject->setShperId($this);
        }

        return $this;
    }

    public function removeScannedObject(ScannedObject $scannedObject): static
    {
        if ($this->scannedObjects->removeElement($scannedObject)) {
            // set the owning side to null (unless already changed)
            if ($scannedObject->getShperId() === $this) {
                $scannedObject->setShperId(null);
            }
        }

        return $this;
    }
}
