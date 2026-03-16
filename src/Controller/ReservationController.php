<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation_form')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();
        $reservation->setStatus('Pending');
        $reservation->setCreatedAt(new \DateTime());
        $reservation->setReferenceCode('LM-' . strtoupper(substr(md5(uniqid()), 0, 5)));

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $reservation->getDate();
            $time = $reservation->getTime();
            $partySize = $reservation->getPartySize();
            $privateDining = $reservation->getPrivateDining();

            $today = new \DateTime();
            $maxDate = (new \DateTime())->modify('+30 days');

            if ($date < $today || $date > $maxDate) {
                $this->addFlash('error', 'Date must be within the next 30 days.');
                return $this->render('reservation/index.html.twig', ['form' => $form->createView()]);
            }

            $now = new \DateTime();

                // Kombiniraj datum i vrijeme u jednu instancu
                $reservationDateTime = \DateTime::createFromFormat(
                    'Y-m-d H:i',
                    $date->format('Y-m-d') . ' ' . $time->format('H:i')
                );

                // Zatvaranje kuhinje u 21:00 istog dana
                $closingTime = \DateTime::createFromFormat(
                    'Y-m-d H:i',
                    $date->format('Y-m-d') . ' 21:00'
                );

                // Provjera: ako je rezervacija u prošlosti ili nakon zatvaranja
                if ($reservationDateTime >= $closingTime || $reservationDateTime < $now) {
                    $this->addFlash('error', 'Cannot place a reservation after kitchen closing hours (21:00) or in the past.');
                    return $this->render('reservation/index.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }


            $dayOfWeek = (int)$date->format('N'); 
            if ($privateDining) {
                if ($dayOfWeek !== 5 && $dayOfWeek !== 6) {
                    $this->addFlash('error', 'Private dining is only available on Fridays and Saturdays.');
                    return $this->render('reservation/index.html.twig', ['form' => $form->createView()]);
                }
                if ($partySize < 6 || $partySize > 12) {
                    $this->addFlash('error', 'Private dining requires 6–12 guests.');
                    return $this->render('reservation/index.html.twig', ['form' => $form->createView()]);
                }

                $existingPrivate = $em->getRepository(Reservation::class)
                    ->findBy(['date' => $date, 'time' => $time, 'privateDining' => true]);

                if (count($existingPrivate) > 0) {
                    $this->addFlash('error', 'This time slot already has a private dining reservation.');
                    return $this->render('reservation/index.html.twig', ['form' => $form->createView()]);
                }
            } else {
             
                $existingRegular = $em->getRepository(Reservation::class)
                    ->findBy(['date' => $date, 'time' => $time, 'privateDining' => false]);

                $currentGuests = array_sum(array_map(fn($r) => $r->getPartySize(), $existingRegular));
                if ($currentGuests + $partySize > 20) {
                    $this->addFlash('error', 'Not enough capacity for this time slot.');
                    return $this->render('reservation/index.html.twig', ['form' => $form->createView()]);
                }
            }

            $em->persist($reservation);
            $em->flush();

            return $this->render('reservation/confirm.html.twig', [
                'reservation' => $reservation,
            ]);
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}