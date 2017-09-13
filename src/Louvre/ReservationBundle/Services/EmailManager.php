<?php

namespace Louvre\ReservationBundle\Services;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class EmailManager
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }


    /**
     * Envoi d'un Email
     *
     * @param $reservation
     * @param $email
     * @param $reservationPrix
     */
    public function sendEmail($reservation, $paymentmail, $reservationPrix)
    {
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setSubject('Votre réservation pour visiter le musée du Louvre')
            ->setFrom('88brunus88@gmail.com')
            ->setTo($paymentmail)   //('root@localhost')
            ->setBody($this->templating->render('LouvreReservationBundle:Emails:reservation.html.twig', array(
                'reservation' => $reservation,
                'reservationPrix' => $reservationPrix,
            ))
            )
        ;

        $this->mailer->send($message);
    }
}
