<?php

namespace App\Entity;

use App\Repository\ScannedObjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScannedObjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ScannedObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photo_path = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdf_path = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shperacze $shper_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $general_description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $background_description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $analysis_result = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $who_brought_object_name_id = null;

    #[ORM\ManyToOne]
    private ?Event $event_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_modified = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fraction $item_possession_id = null;

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

    public function getPhotoPath(): ?string
    {
        return $this->photo_path;
    }

    public function setPhotoPath(string $photo_path): static
    {
        $this->photo_path = $photo_path;

        return $this;
    }

    public function getPdfPath(): ?string
    {
        return $this->pdf_path;
    }

    public function setPdfPath(?string $pdf_path): static
    {
        $this->pdf_path = $pdf_path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getShperId(): ?Shperacze
    {
        return $this->shper_id;
    }

    public function setShperId(?Shperacze $shper_id): static
    {
        $this->shper_id = $shper_id;

        return $this;
    }

    public function getGeneralDescription(): ?string
    {
        return $this->general_description;
    }

    public function setGeneralDescription(?string $general_description): static
    {
        $this->general_description = $general_description;

        return $this;
    }

    public function getBackgroundDescription(): ?string
    {
        return $this->background_description;
    }

    public function setBackgroundDescription(?string $background_description): static
    {
        $this->background_description = $background_description;

        return $this;
    }

    public function getAnalysisResult(): ?string
    {
        return $this->analysis_result;
    }

    public function setAnalysisResult(?string $analysis_result): static
    {
        $this->analysis_result = $analysis_result;

        return $this;
    }

    public function getWhoBroughtObjectNameId(): ?string
    {
        return $this->who_brought_object_name_id;
    }

    public function setWhoBroughtObjectNameId(?string $who_brought_object_name_id): static
    {
        $this->who_brought_object_name_id = $who_brought_object_name_id;

        return $this;
    }

    public function getEventId(): ?Event
    {
        return $this->event_id;
    }

    public function setEventId(?Event $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getItemPossessionId(): ?Fraction
    {
        return $this->item_possession_id;
    }

    public function setItemPossessionId(?Fraction $item_possession_id): static
    {
        $this->item_possession_id = $item_possession_id;

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
