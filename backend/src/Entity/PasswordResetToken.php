<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PasswordResetTokenRepository;

#[ORM\Entity(repositoryClass: PasswordResetTokenRepository::class)]
class PasswordResetToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private User $user;

    #[ORM\Column(type: 'string', unique: true)]
    private string $token;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $expiresAt;

    public function __construct(User $user, string $token, int $expirationMinutes = 15)
    {
        $this->user = $user;
        $this->token = $token;
        $this->expiresAt = (new \DateTime())->modify("+{$expirationMinutes} minutes");
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getToken(): string
    {
        return $this->token;
    }
    public function getExpiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }
    public function isExpired(): bool
    {
        return new \DateTime() > $this->expiresAt;
    }
}
