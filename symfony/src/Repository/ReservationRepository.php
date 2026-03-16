<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function countGuests($date,$time)
    {
        return $this->createQueryBuilder('r')
            ->select('SUM(r.partySize)')
            ->where('r.date = :date')
            ->andWhere('r.time = :time')
            ->setParameter('date',$date)
            ->setParameter('time',$time)
            ->getQuery()
            ->getSingleScalarResult();
    }
}