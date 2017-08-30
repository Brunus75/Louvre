<?php

namespace tests\ReservationBundle\Services;

use Louvre\ReservationBundle\Services\PrixManager;
use Louvre\ReservationBundle\Entity\Reservation;
use Louvre\ReservationBundle\Entity\Client;

class PrixManagerTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $reservation;
    private $PrixManager;
    private $format = 'd/m/Y';

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
        $this->reservation = new Reservation();
        $this->PrixManager = new PrixManager();
    }

    private function getPreviousYears($years)
    {
        $time = new \DateTime('now');
        $newTime = $time->modify($years)->format('d/m/Y');
        return $newTime;
    }

    /**
     * Affirme qu'un enfant de moins de 4 ans ne paie rien
     */
    public function testCalculateReturnsGoodPrixForToddler()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-2 years")))->setDiscount(false);
        $this->reservation->addClient($this->client)->setType('journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(0, $result);
    }

    /**
     * Affirme qu'un enfant de 4 à 12 ans paie 8 euros
     */
    public function testCalculateReturnsGoodPrixForChild()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-5 years")))->setDiscount(false);
        $this->reservation->addClient($this->client)->setType('journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(8, $result);
    }

    /**
     * Affirme qu'une personne entre 13 et 60 paie 16 euros
     */
    public function testCalculateReturnsGoodPrixForRegularClient()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-13 years")))->setDiscount(false);
        $this->reservation->addClient($this->client)->setType('journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(16, $result);
    }

    /**
     * Affirme qu'une personne âgée de plus de 60 ans paie 12 euros
     */
    public function testCalculateReturnsGoodPrixForOldClient()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-61 years")))->setDiscount(false);
        $this->reservation->addClient($this->client)->setType('journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(12, $result);
    }

    /**
     * Affirme qu'une personne avec un rabais paie 10 euros
     */
    public function testCalculateReturnsGoodPrixForClientWithDiscount()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-26 years")))->setDiscount(true);
        $this->reservation->addClient($this->client)->setType('journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(10, $result);
    }

    /**
     * Affirme que le Prix de la réservation est divisé par 2 lorsque le type est "demi-journée"
     */
    public function testCalculateReturnsGoodPrixForDemiJournee()
    {
        $this->client->setAnniversaire(\DateTime::createFromFormat($this->format, $this->getPreviousYears("-13 years")))->setDiscount(false);
        $this->reservation->addClient($this->client)->setType('demi-journée');
        $result = $this->PrixManager->calculate($this->reservation);
        $this->assertEquals(8, $result);
    }
}
