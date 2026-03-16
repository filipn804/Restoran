<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $dateFilter = $request->query->get('date');
        $statusFilter = $request->query->get('status');

        $repo = $em->getRepository(Reservation::class);
        $qb = $repo->createQueryBuilder('r')
            ->orderBy('r.date', 'ASC');

        if ($dateFilter) {
            $qb->andWhere('r.date = :date')->setParameter('date', new \DateTime($dateFilter));
        }

        if ($statusFilter) {
            $qb->andWhere('r.status = :status')->setParameter('status', $statusFilter);
        }

        $reservations = $qb->getQuery()->getResult();

        $totalGuests = array_reduce($reservations, function ($carry, $r) {
            return $carry + $r->getPartySize();
        }, 0);

        return $this->render('admin/index.html.twig', [
            'reservations' => $reservations,
            'totalGuests' => $totalGuests,
            'dateFilter' => $dateFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    #[Route('/admin/reservation/{id}', name: 'admin_reservation_detail')]
    public function detail(Reservation $reservation, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $newStatus = $request->request->get('status');
            if (in_array($newStatus, ['Pending', 'Confirmed', 'Cancelled', 'Completed'])) {
                $reservation->setStatus($newStatus);
                $em->flush();
                $this->addFlash('success', 'Status updated!');
            }
        }

        return $this->render('admin/detail.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}