<?php

namespace App\Tests;

use App\Entity\Reservation;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function testTotalGuestsCalculation()
    {
        $reservations = [
            (new Reservation())->setPartySize(4),
            (new Reservation())->setPartySize(6),
            (new Reservation())->setPartySize(3),
        ];

        $totalGuests = array_reduce($reservations, fn($carry, $r) => $carry + $r->getPartySize(), 0);

        $this->assertEquals(13, $totalGuests);
    }
}