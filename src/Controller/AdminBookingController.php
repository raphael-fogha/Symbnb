<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * Affiche les reservations
     * 
     * @Route("/admin/booking", name="admin_booking")
     * 
     * @param BookingRepository $repo
     * @return Response
     */
    public function index(BookingRepository $repo)
    {   

        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll(),
        ]);
    }

    /**
     * Permet d'editer une reservation
     * 
     * @Route("/admin/booking/{id}/edit", name="admin_booking_edit")
     *
     * @return Response
     */
    public function edit(Booking $booking,ObjectManager $manager, Request $request)
    {   
        $form = $this->createForm(AdminBookingType::class,$booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   
            //Permet recalcul automatique du montant
            //grace à function PrePersist de l'entité Booking
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                "success",
                "La réservation n°<strong>{$booking->getId()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute("admin_booking");
        }

        return $this->render("admin/booking/edit.html.twig",[
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * Permet de supprimer une reservation
     *
     * @Route("/admin/booking/{id}/delete", name="admin_booking_delete")
     * 
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager)
    {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            'La réservation a bien été supprimée !'
        );

        return $this->redirectToRoute("admin_booking");
    }
}
