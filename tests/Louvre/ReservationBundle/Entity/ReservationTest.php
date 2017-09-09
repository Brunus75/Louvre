<?php

namespace tests\Louvre\ReservationBundle\Entity;

use Louvre\ReservationBundle\Entity\Reservation;

class ReservationTest extends \PHPUnit_Framework_TestCase
{
    private $reservation;

    public function __construct()
    {
        parent::__construct();
        $this->reservation = new Reservation();
    }

    public function testNomReservation()
    {
        $this->reservation->setNomReservation('Test');
        $this->assertNotEquals('Tests', $this->reservation->getNomReservation());
        $this->assertEquals('Test', $this->reservation->getNomReservation());
    }

    public function testDate()
    {
        $this->reservation->setDate(new \Datetime('20-09-2017'));
        $this->assertNotEquals(new \Datetime('20-10-2017'), $this->reservation->getDate());
        $this->assertEquals(new \Datetime('20-09-2017'), $this->reservation->getDate());
    }

    public function testType()
    {
        $this->reservation->setType('Journee');
        $this->assertNotEquals('Demi-journee', $this->reservation->getType());
        $this->assertEquals('Journee', $this->reservation->getType());
    }

    public function testNumeroTickets()
    {
        $this->reservation->setNumeroTickets(2);
        $this->assertNotEquals(1, $this->reservation->getNumeroTickets());
        $this->assertEquals(2, $this->reservation->getNumeroTickets());
    }
}
