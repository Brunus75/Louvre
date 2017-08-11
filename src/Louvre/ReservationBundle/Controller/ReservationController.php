<?php

namespace Louvre\ReservationBundle\Controller;

use Louvre\ReservationBundle\Entity\Client;
#use Louvre\ReservationBundle\Form\InfoStepType;
use Symfony\Component\HttpFoundation\Request;
use Louvre\ReservationBundle\Entity\Reservation;
#use Louvre\ReservationBundle\Form\ReservationType;
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

        return $this->render('Reservation/index.html.twig', array(
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

        return $this->render('Reservation/information.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
