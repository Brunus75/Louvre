<?php

namespace Louvre\ReservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NombreMaxTickets
 * @Annotation
 * @package Louvre\ReservationBundle\Validator\Constraints
 */
class NombreMaxTickets extends Constraint
{
    public $message = 'Le nombre de billets vendus a atteint son maximum (1000).';
}
