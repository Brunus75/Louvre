<?php

namespace Louvre\ReservationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Louvre\ReservationBundle\Validator\OrderCheck;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Louvre\ReservationBundle\Repository\ReservationRepository")
 * @OrderCheck()
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomReservation", type="string", length=255)
     */
    private $nomReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="fullDay", type="boolean")
     */
    private $jourEntier = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * @var int
     *
     * @ORM\Column(name="numeroTickets", type="integer")
     */
    private $numeroTickets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReservation", type="date")
     * @Assert\NotBlank(message="entry_date.blank")
     */
    private $dateReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroReservation", type="string", length=255, nullable=true)
     */
    private $numeroReservation;

    /**
     * @ORM\OneToMany(targetEntity="Louvre\ReservationBundle\Entity\Client", mappedBy="reservation", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $clients;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->date  = new \DateTime();
        $this->nomReservation         = strtoupper(uniqid('LOUVRE'));
        $this->clients     = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomReservation
     *
     * @param string $nomReservation
     *
     * @return Reservation
     */
    public function setNomReservation($nomReservation)
    {
        $this->nomReservation = strtolower($nomReservation);

        return $this;
    }

    /**
     * Get nomReservation
     *
     * @return string
     */
    public function getNomReservation()
    {
        return $this->nomReservation;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = strtolower($email);

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set jourEntier
     *
     * @param boolean $fullDay
     *
     * @return Reservation
     */
    public function setJourEntier($jourEntier)
    {
        $this->jourEntier = $jourEntier;

        return $this;
    }

    /**
     * Get jourEntier
     *
     * @return bool
     */
    public function getJourEntier()
    {
        return (bool) $this->jourEntier;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set numeroTickets
     *
     * @param integer $numeroTickets
     *
     * @return Reservation
     */
    public function setNumeroTickets($numeroTickets)
    {
        $this->numeroTickets = $numeroTickets;

        return $this;
    }

    /**
     * Get numeroTickets
     *
     * @return int
     */
    public function getNumeroTickets()
    {
        return $this->numeroTickets;
    }

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Reservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set numeroReservation
     *
     * @param string $numeroReservation
     *
     * @return Reservation
     */
    public function setNumeroReservation($numeroReservation)
    {
        $this->numeroReservation = $numeroReservation;

        return $this;
    }

    /**
     * Get numeroReservation
     *
     * @return string
     */
    public function getNumeroReservation()
    {
        return $this->numeroReservation;
    }

    /**
     * Add client
     *
     * @param \Louvre\ReservationBundle\Entity\Client $client
     *
     * @return Reservation
     */
    public function addClient(\Louvre\ReservationBundle\Entity\Client $client)
    {
        $this->clients[] = $client;
        $client->setReservation($this);
        return $this;
    }

    /**
     * Remove client
     *
     * @param \Louvre\ReservationBundle\Entity\Client $client
     */
    public function removeClient(\Louvre\ReservationBundle\Entity\Client $client)
    {
        $this->clients->removeElement($client);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Récupération du nombre de tickets
     *
     * @return int
     */
    public function getCountClients()
    {
        return count($this->clients);
    }

    /**
     * Calcule le montant total de la commande
     *
     * @return int
     */
    public function getTotalPrix()
    {
        $visitors = $this->getClients();
        $total = 0;

        foreach($clients as $client){
            $total = $total + $client->getPrix();
        }

        return $total;
    }
}

