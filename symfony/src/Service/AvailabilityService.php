<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;

class AvailabilityService
{
    public function __construct(private ReservationRepository $repo){}

    public function checkCapacity(Reservation $reservation)
    {
        $guests = $this->repo->countGuests(
            $reservation->getDate(),
            $reservation->getTime()
        );

        return ($guests + $reservation->getPartySize()) <= 20;
    }
}