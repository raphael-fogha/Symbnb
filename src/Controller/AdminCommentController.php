<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentEditType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Affiche l'ensemble des commentaires 
     * 
     * @Route("/admin/comment", name="admin_comment")
     * 
     * @param CommentRepository $repo
     * @return Response
     */
    public function index(CommentRepository $repo)
    {   
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $repo->findAll(),
        ]);
    }

    /**
     * Affiche formulaire d'édition d'un commentaire
     * 
     * @Route("/admin/{id}/edit", name="admin_comment_edit")
     *
     * @param Comment $comment
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Comment $comment, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(CommentEditType::class, $comment);
        
        return $this->render('admin/comment/edit.html.twig',[
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }
}

