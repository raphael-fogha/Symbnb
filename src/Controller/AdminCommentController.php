<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Service\Pagination;
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
     * @Route("/admin/comment/{page<\d+>?1}", name="admin_comment")
     * 
     * @param CommentRepository $repo
     * @return Response
     */
    public function index(CommentRepository $repo,Pagination $pagination,$page)

    {    $pagination->setEntityClass(Comment::class)
                    ->setPage($page)
                    ->setLimit(10);

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination
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
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                "success",
                "Le commentaire n°{$comment->getid()} a bien été modifié !"
            );

            return $this->redirectToRoute('admin_comment');
        }

        return $this->render('admin/comment/edit.html.twig',[
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }

    /**
     * Supprime un commentaire
     * 
     * @Route("/admin/{id}/delete", name="admin_comment_delete")
     * 
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Comment $comment, ObjectManager $manager)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire a bien été supprimé !"
        );

        return $this->redirectToRoute("admin_comment");
    }
}

