<?php

namespace Louvre\ReservationBundle\Repository;

use function explode;
use Symfony\Component\Validator\Constraints\DateTime;

class ReservationRepository extends \Doctrine\ORM\EntityRepository
{

    public function findTotalTickets($selectedDate)
    {
        $selectedDate = explode('/', $selectedDate);
        $dateformat = $selectedDate[1].'/'.$selectedDate[0].'/'.$selectedDate[2];
        $selectedDate = new \DateTime($dateformat);

        $query = $this->createQueryBuilder('t')
            ->select('SUM(t.numeroTickets)')
            ->where('t.date = :date')
            ->setParameter('date', $selectedDate)
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}