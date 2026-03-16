<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Service\ReferenceGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicReservationController extends AbstractController
{
    #[Route('/',name:'home')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        ReferenceGenerator $generator
    ){
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $reservation->setReferenceCode($generator->generate());

            $em->persist($reservation);
            $em->flush();

            return $this->render('public/confirmation.html.twig',[
                'reservation'=>$reservation
            ]);
        }

        return $this->render('public/form.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}