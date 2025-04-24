<?php

namespace App\Entity;

use App\Repository\NegociationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NegociationRepository::class)]
#[ORM\UniqueConstraint(
    name: "unique_negociation_per_user_room",
    columns: ["user_id", "room_id"]
)]
class Negociation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\OneToOne(inversedBy: 'negociation', cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'negociations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'negociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $room = null;

    #[ORM\Column]
    private ?float $proposedPrice = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $responseTime = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?float $counterOffer = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getProposedPrice(): ?float
    {
        return $this->proposedPrice;
    }

    public function setProposedPrice(float $proposedPrice): static
    {
        $this->proposedPrice = $proposedPrice;

        return $this;
    }

    public function getResponseTime(): ?\DateTimeImmutable
    {
        return $this->responseTime;
    }

    public function setResponseTime(?\DateTimeImmutable $responseTime): static
    {
        $this->responseTime = $responseTime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCounterOffer(): ?float
    {
        return $this->counterOffer;
    }

    public function setCounterOffer(?float $counterOffer): static
    {
        $this->counterOffer = $counterOffer;

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
}
