<?php

namespace Louvre\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Louvre\ReservationBundle\Validator\Constraints as MyAssert;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="Louvre\ReservationBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     * @MyAssert\ContainsLettersAndAccents()
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @MyAssert\ContainsLettersAndAccents()
     */
    private $nom;

    /**
     * @var \DateTime
     * @ORM\Column(name="anniversaire", type="datetime")
     */
    private $anniversaire;

    /**
     * @var string
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var boolean
     * @ORM\Column(name="discount", type="boolean")
     */
    private $discount = false;

    /**
     * @var integer;
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="Reservation", inversedBy="clients", cascade={"persist", "remove"})
     */
    private $reservation;

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prenom
     * @param string $prenom
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     * @param string $nom
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set anniversaire
     * @param \DateTime $anniversaire
     * @return Client
     */
    public function setAnniversaire($anniversaire)
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    /**
     * Get anniversaire
     * @return \DateTime
     */
    public function getAnniversaire()
    {
        return $this->anniversaire;
    }

    /**
     * Set pays
     * @param string $pays
     * @return Client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set reservation
     * @param \Louvre\ReservationBundle\Entity\Reservation $reservation
     * @return Client
     */
    public function setReservation(Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     * @return \Louvre\ReservationBundle\Entity\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set discount
     * @param boolean $discount
     * @return Client
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     * @return boolean
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }
}
