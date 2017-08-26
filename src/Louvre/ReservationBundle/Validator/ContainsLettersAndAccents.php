<?php

namespace Louvre\ReservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Class ContainsLettersAndAccents
 * @package Louvre\ReservationBundle\Validator\Constraints
 */
class ContainsLettersAndAccents extends Constraint
{
    public $message =
        '"{{ string }}" contient un ou plusieurs caractères interdits : 
        ce champ ne peut pas contenir de chiffre.'
    ;
}
