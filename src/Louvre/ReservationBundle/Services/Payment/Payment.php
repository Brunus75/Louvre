<?php

namespace Louvre\ReservationBundle\Services\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Louvre\ReservationBundle\Entity\Reservation;



class Payment
{

    /**
     * Paiement de la commande
     *
     * @param Reservation $reservation
     * @param Request $request
     * @return bool
     */
    public function sendingPayment(Reservation $reservation, $token)
        {
            \Stripe\Stripe::setApiKey("sk_test_NIv47DBDIXBHBdKnlWSnEIaV");

        // On vérifie si le paiement a été accepté.
        // Si le paiement n'est pas valide pour notre cas, on retourne false
        // afin d'afficher un message global à l'utilisateur.
        try {
            \Stripe\Charge::create(array(
                "amount"        => $reservation->getTotalPrix() * 100 ,
                "currency"      => "eur",
                "description"   => "Musée du Louvre - Paiement des billets",
                "source"        => $token,
            ));
            $stripeinfo = \Stripe\Token::retrieve($token);
            $clientEmail = $stripeinfo->email;
return $clientEmail;


        } catch(\Stripe\Error\Card $e) {
            // la carte n'est pas valide
            return false;

        } catch (\Stripe\Error\InvalidRequest $e) {
            // Des paramètres non valides ont été envoyé à l'API Stripe
            return false;

        } catch (\Stripe\Error\Authentication $e) {
            // L'authentification avec Stripe a échoué
            return false;

        } catch (\Stripe\Error\ApiConnection $e) {
            // La communication réseau avec Stripe a échoué
            return false;

        } catch (\Stripe\Error\Base $e) {
            // Affiche une erreur générique à l'utilisateur
            return false;

        } catch (Exception $e) {
            // Une autre chose s'est produite, totalement sans lien avec Stripe
            return false;
        }

        return true;

    }
}

