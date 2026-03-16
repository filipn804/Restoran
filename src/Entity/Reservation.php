<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'reservation')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $fullName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^\+?[0-9\s\-]{7,15}$/",
        message: "Phone number is invalid."
    )]
    private string $phone;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    private \DateTimeInterface $date;

    #[ORM\Column(type: 'time')]
    #[Assert\NotNull]
    private \DateTimeInterface $time;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive]
    private int $partySize;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $specialRequest = null;

    #[ORM\Column(type: 'boolean')]
    private bool $privateDining = false;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status;

    #[ORM\Column(type: 'string', length: 50)]
    private string $referenceCode;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function getId(): ?int { return $this->id; }
    public function getFullName(): string { return $this->fullName; }
    public function setFullName(string $fullName): self { $this->fullName = $fullName; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPhone(): string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }

    public function getDate(): \DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }

    public function getTime(): \DateTimeInterface { return $this->time; }
    public function setTime(\DateTimeInterface $time): self { $this->time = $time; return $this; }

    public function getPartySize(): int { return $this->partySize; }
    public function setPartySize(int $partySize): self { $this->partySize = $partySize; return $this; }

    public function getSpecialRequest(): ?string { return $this->specialRequest; }
    public function setSpecialRequest(?string $specialRequest): self { $this->specialRequest = $specialRequest; return $this; }

    public function getPrivateDining(): bool { return $this->privateDining; }
    public function setPrivateDining(bool $privateDining): self { $this->privateDining = $privateDining; return $this; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }

    public function getReferenceCode(): string { return $this->referenceCode; }
    public function setReferenceCode(string $referenceCode): self { $this->referenceCode = $referenceCode; return $this; }

    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }
}