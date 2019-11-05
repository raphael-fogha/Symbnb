<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello")
     * @Route("/hello", name="hello_base")
     * @Route("/hello/{prenom}", name="hello_prenom")
     * Montre la page qui dit bonjour
     *
     * @return void
     */
    public function hello($prenom = "anonyme",$age = 0){
        return new Response("Bonjour " . $prenom. " vous avez " . $age . " ans" );
    }
   
    
    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        $prenoms = ['Lior' => 190,'Joseph' => 175,'Anne' => 155];
        $ages = ['Mica' => 21, 'Uriel' => 30, 'Raphael' => 23];

        return $this->render(
            'home.html.twig',
            ['title' => 'Bonjour à vous !',
            'salut' => 'Comment vous-portez vous ?',
            'age' => 19,
            'adulte' => 'Vous ête un adulte',
            'ado' => 'Vous ête un ado',
            'enfant' => 'Vous ête un enfant',
            'tableau' => $prenoms,
            'tableau2' => $ages,
            ] 

        );
    }
}

?>