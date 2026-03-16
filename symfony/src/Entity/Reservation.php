<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:20)]
    private string $referenceCode;

    #[ORM\Column(length:255)]
    private string $fullName;

    #[ORM\Column(length:255)]
    private string $email;

    #[ORM\Column(length:30)]
    private string $phone;

    #[ORM\Column(type:"date")]
    private \DateTimeInterface $date;

    #[ORM\Column(type:"time")]
    private \DateTimeInterface $time;

    #[ORM\Column]
    private int $partySize;

    #[ORM\Column(type:"text", nullable:true)]
    private ?string $specialRequests = null;

    #[ORM\Column]
    private bool $privateDining = false;

    #[ORM\Column(length:20)]
    private string $status = "Pending";
}