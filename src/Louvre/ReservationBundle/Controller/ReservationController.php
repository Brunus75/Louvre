<?php

namespace Louvre\ReservationBundle\Controller;

use Louvre\ReservationBundle\Entity\Client;
use Louvre\ReservationBundle\Form\InfoStepType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Louvre\ReservationBundle\Entity\Reservation;
use Louvre\ReservationBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReservationController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            for($i = 0; $i<$reservation->getNumeroTickets(); $i++) {
                $client = new Client();
                $reservation->addClient($client);
            }

            $this->get('session')->set('reservation', $reservation);
            return $this->redirectToRoute('information');
        }

        return $this->render('LouvreReservationBundle:Reservation:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/information", name="information")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function informationAction(Request $request)
    {
        $reservation = $this->get('session')->get('reservation');

        if(!$reservation)
            throw new \Exception();

        $form = $this->createForm(InfoStepType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->get('session')->set('reservation', $reservation);
            return $this->redirectToRoute('payment');
        }

        return $this->render('LouvreReservationBundle:Reservation:information.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/payment", name="payment")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function paymentAction()
    {
        $reservation = $this->get('session')->get('reservation');
        $prix = $this->get('louvre_reservation_prixmanager')->calculate($reservation);
        $this->get('session')->set('prix', $prix);

        return $this->render('LouvreReservationBundle:Reservation:payment.html.twig', array(
            'reservation' => $reservation,
            'prix' => $prix,
        ));
    }

    /**
     * @Route("/checkout", name="checkout")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function checkoutAction(Request $request)
    {
        $session = $request->getSession();
        $prix = $this->get('session')->get('prix');
        $reservationPrix = $prix;
        $reservation = $this->get('session')->get('reservation');

//        \Stripe\Stripe::setApiKey("sk_test_NIv47DBDIXBHBdKnlWSnEIaV");
        // Obtenir les détails de la carte de crédit soumis par le formulaire
        $token = $request->get('stripeToken');

        $paymentmail = $this->get('louvre_reservation_payment')->sendingPayment($reservation, $token);


            //Récupération de l'adresse électronique du client

            $reservation->setEmail($paymentmail);
            $reservationCode = $this->get('louvre.reservation_codereservationmanager')->generateCode($reservation);
            $reservation->setNumeroReservation($reservationCode);

            // Persisting & flushing reservation & client(s)
            $em = $this->getDoctrine()->getManager();
            $em->persist($session->get('reservation'));
            $em->flush();

            // Envoi du courrier électronique de confirmation
            $this->get('louvre_reservation_emailmanager')->sendEmail($reservation, $paymentmail, $reservationPrix);

            // Lecture de toutes les données de session et identification de la session de régénération ID
            $session->invalidate();

            return $this->render('LouvreReservationBundle:Reservation:success.html.twig');

    }

}
