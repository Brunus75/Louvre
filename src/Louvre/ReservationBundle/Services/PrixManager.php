<?php

namespace Louvre\ReservationBundle\Services;

use Louvre\ReservationBundle\Entity\Reservation;

class PrixManager
{
    private function getPrix($age, $discount) {
        if($age >= 0 && $age <= 4) {
            return 0;
        }
        if($discount) {
            if($age > 4 && $age < 12) {
                return 8;
            }
            return 10;
        }
        if($age > 4 && $age < 12) {
            return 8;
        }
        if($age >= 12 && $age <= 60) {
            return 16;
        }

        return 12;
    }

    public function calculate(Reservation $reservation)
    {
        $total = null;

        // Date actuelle.
        $today = new \Datetime();
        $today->format('d-m-Y');

        // Tableau contenant les différents clients
        $clients = $reservation->getClients();

        foreach($clients as $client) {
            // Variables utiles
            $anniversaire = $client->getAnniversaire(); // Datetime object
            $discount = $client->getDiscount(); // Boolean

            // Intervalle entre l'anniversaire du client et la date actuelle.
            $interval = $anniversaire->diff($today);

            // L'âge du client = année dans cet intervalle.
            $clientsAge = $interval->y;

            $prix = $this->getPrix($clientsAge, $discount);

            if($reservation->getType() === "demi-journee") {
                $prix = $prix / 2;
            }
            $client->setPrix($prix);
            $total += $prix;
        }

        return $total;
    }
}
