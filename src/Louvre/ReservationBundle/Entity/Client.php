<?php

namespace Louvre\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="Reservation", inversedBy="clients", cascade={"persist", "remove"})
     */
    private $reservation;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anniversaire", type="date")
     * @Assert\Date()
     * @BirthdayCheck()
     */
    private $anniversaire;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     * @Assert\Pays()
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="promo", type="boolean")
     */
    private $promo;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->reduit      = false;
        $this->type         = 'NORMAL';
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
     * Set reservation
     *
     * @param \Louvre\ReservationBundle\Entity\Reservation
     *
     * @return Client
     */
    public function setReservation(\Louvre\ReservationBundle\Entity\Reservation $reservation)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Louvre\ReservationBundle\Entity\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = strtolower($prenom);

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = strtolower($nom);

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set anniversaire
     *
     * @param \DateTime $anniversaire
     *
     * @return Client
     */
    public function setAnniversaire($anniversaire)
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    /**
     * Get anniversaire
     *
     * @return \DateTime
     */
    public function getAnniversaire()
    {
        return $this->anniversaire;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set promo
     *
     * @param boolean $promo
     *
     * @return Client
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return bool
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set prix
     *
     * @param string $price
     *
     * @return Client
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Client
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Récupére l'age du visiteur
     *
     * @return int
     */
    public function getAge()
    {
        return $this->getAnniversaire()->diff(new \DateTime())->y;
    }
}

