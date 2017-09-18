<?php

namespace Louvre\ReservationBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NombreMaxTicketsValidator extends ConstraintValidator
{
    protected $entityManager;
    protected $request;

    public function __construct(EntityManager $em, RequestStack $request)
    {
        $this->entityManager = $em;
        $this->request = $request;
    }

    public function validate($value, Constraint $constraint)
    {
        // Récupérer le request
        $request = $this->request->getCurrentRequest();

        // Récupérer la date sélectionnée dans jQuery UI datepicker
        $selectedDate = $request->request->get('louvre_reservationbundle_reservation')['date'];

        // Nombre de tickets requis par l'utilisateur
        $nbOfTickets = $request->request->get('louvre_reservationbundle_reservation')['numeroTickets'];

        // Entity Manager
        $em = $this->entityManager;

        // Récupérer tous les objets «Réservé» dont la date est égale à la date sélectionnée
        $totalTickets = $em->getRepository('LouvreReservationBundle:Reservation')->findTotalTickets($selectedDate);

      //var_dump($selectedDate); die();   // ok $selectedDate -  $nbOfTickets ok


        // Billets restants
        $remainingTickets = 1000 - $totalTickets;

      //var_dump($totalTickets); die();
        /*
         * Si le nombre de tickets requis par l'utilisateur est supérieur à
         * le nombre de billets restants, alors la réservation n'est pas autorisée.
         */
        if($nbOfTickets > $remainingTickets)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
