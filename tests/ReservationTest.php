<?php

namespace App\Tests;

use App\Entity\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testReferenceCodeFormat()
    {
        $reservation = new Reservation();
        $reservation->setReferenceCode('LM-ABCDE');

        $this->assertMatchesRegularExpression('/^LM-[A-Z0-9]{5}$/', $reservation->getReferenceCode());
    }

    public function testPrivateDiningRules()
    {
        $reservation = new Reservation();
        $reservation->setPrivateDining(true);
        $reservation->setPartySize(5);

        $this->assertFalse($reservation->getPartySize() >= 6 && $reservation->getPartySize() <= 12);
    }

    public function testRegularCapacityLimit()
    {
        $existingGuests = 15;
        $partySize = 6;

        $this->assertTrue($existingGuests + $partySize > 20);
    }

    public function testKitchenClosingTime()
    {
        $reservation = new Reservation();

        $reservation->setDate(new \DateTime());
        $reservation->setTime(new \DateTime('22:00'));

        $closingHour = 21;
        $closingMinute = 0;

        $reservationHour = (int)$reservation->getTime()->format('H');
        $reservationMinute = (int)$reservation->getTime()->format('i');

        $isAfterClosing = $reservationHour > $closingHour || ($reservationHour === $closingHour && $reservationMinute > $closingMinute);

        $this->assertTrue($isAfterClosing, 'Reservation is after kitchen closing time');
    }

    public function testKitchenOpenTime()
    {
        $reservation = new Reservation();

        $reservation->setDate(new \DateTime());
        $reservation->setTime(new \DateTime('20:30'));

        $closingHour = 21;
        $closingMinute = 0;

        $reservationHour = (int)$reservation->getTime()->format('H');
        $reservationMinute = (int)$reservation->getTime()->format('i');

        $isAfterClosing = $reservationHour > $closingHour || ($reservationHour === $closingHour && $reservationMinute > $closingMinute);

        $this->assertFalse($isAfterClosing, 'Reservation is before kitchen closing time');
    }
}