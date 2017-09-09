<?php

namespace Louvre\ReservationBundle\Services;

class CodeReservationManager
{
    public function generateCode($reservation)
    {
        $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $shuffledLetters = str_shuffle($letters);

        $code = substr($shuffledLetters, 0, 4) .
        $reservation->getId() .
        $reservation->getDate()->format('dmY') .
        substr($reservation->getNomReservation(), 0, 3) .
        $reservation->getNumeroTickets() .
        $reservation->getDateReservation()->format('dmy');

        return $code;
    }
}
