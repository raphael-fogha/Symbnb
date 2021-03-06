<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class StatsService{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getStats()
    {
        $users = $this->getUsersCount();
        $ads = $this->getAdsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();

        return compact('users','ads','bookings','comments');
    }

    public function getUsersCount()
    {
        return $users = $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')
        ->getSingleScalarResult();
    }
    public function getAdsCount()
    {
        return $ads = $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')
        ->getSingleScalarResult();
    }
    public function getBookingsCount()
    {
        return $bookings =  $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')
        ->getSingleScalarResult();
    }
    public function getCommentsCount()
    {
        return $users = $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')
        ->getSingleScalarResult();
    }

    public function getAds($order)
    {
        return $this->manager->createQuery(
            "SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName,  u.picture
            FROM App\Entity\Comment c
            JOIN c.ad a 
            JOIN a.author u
            GROUP BY a
            ORDER BY note $order"

        )->setMaxResults(5)
        ->getResult();
    }

   
}