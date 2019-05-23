<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends BaseAdminController
{
    /**
     * @Route("/comment/{slug}/new", name="app_comment_new")
     * @Method("POST")
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function new(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $post->addComment($comment);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app_read_post', [
                'post' => $post,
                'slug' => $post->getSlug(),
            ]);
        }

        return $this->render('comments/comment-form.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/comment/{slug}/reply/{parent}", name="app_reply_new")
     * @Method("POST")
     * @param Request $request
     * @param Post $post
     * @param Comment $parent
     * @return Response
     */
    public function reply(Post $post, Comment $parent, Request $request): Response
    {
        /** @var Comment $reply */
        $reply = new Comment();

        $form = $this->createForm(CommentType::class, $reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reply->setAuthor($this->getUser());
            $reply->setContent($form->getData()->getContent());
            $reply->setParent($parent);
            $parent->addChildren($reply);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();

            return $this->redirectToRoute('app_read_post', [
                'post' => $post,
                'slug' => $post->getSlug(),
            ]);
        }

        return $this->render('comments/reply-form.html.twig', [
            'post' => $post,
            'comment' => $parent,
            'form' => $form->createView(),
        ]);
    }
}