<?php

namespace tests\louvre\ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = static::createClient();
    }

    public function testIndexAction()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->followRedirects();

        $form = $crawler->selectButton('Continuer')->form();

        $form['louvre_reservationbundle_reservation[nomReservation]'] = "Test";
        $form['louvre_reservationbundle_reservation[date]'] = "07/09/2017";
        $form['louvre_reservationbundle_reservation[type]'] = "journée";
        $form['louvre_reservationbundle_reservation[numeroTickets]'] = 1;

        $crawler = $this->client->submit($form);

        $this->assertContains("Votre réservation", $this->client->getResponse()->getContent());
    }

    public function testInformationAction()
    {
        $this->testIndexAction();

        $crawler = $this->client->request('GET', '/information');
        $form = $crawler->selectButton('Continuer')->form();

        $form['louvre_reservationbundle_reservation[clients][0][prenom]'] = 'Bruno';
        $form['louvre_reservationbundle_reservation[clients][0][nom]'] = 'Henri';
        $form['louvre_reservationbundle_reservation[clients][0][anniversaire][day]'] = 01;
        $form['louvre_reservationbundle_reservation[clients][0][anniversaire][month]'] = 1;
        $form['louvre_reservationbundle_reservation[clients][0][anniversaire][year]'] = 1995;
        $form['louvre_reservationbundle_reservation[clients][0][pays]'] = 'FR';
        $form['louvre_reservationbundle_reservation[clients][0][discount]'] = 1;

        $crawler = $this->client->submit($form);

        $this->assertContains('Récapitulatif', $this->client->getResponse()->getContent());
    }
}
