<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\UserRepository;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{


    
    /**
     * Affiche la page d'accueil
     * 
     * @Route("/{page<\d+>?1}", name="homepage")
     */
    public function index(Pagination $pagination,UserRepository $repo, $page)
    {   
        $user1 = $repo->findOneBy([
            'id' => 100
        ]);
        $user2 = $repo->findOneBy([
            'id' => 105
        ]);
        $pagination->setEntityClass(Ad::class)
                    ->setPage($page)
                    ->setLimit(3);

        return $this->render('home.html.twig',[
            'pagination' => $pagination,
            'user1' => $user1,
            'user2' => $user2
        ]);
    }
}

