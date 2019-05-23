<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Exception\EditPostException;
use App\Form\PostType;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use EasyCorp\Bundle\EasyAdminBundle\Exception\EntityRemoveException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends BaseAdminController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * SeanceController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Post $post
     * @Route("/post/read/{slug}", name="app_read_post")
     * @return Response
     */
    public function read(Post $post): Response
    {
        return new Response($this->renderView('posts/read.html.twig', [
            'post' => $post,
        ]));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @Route("/post/edit/{slug}", name="app_edit_post")
     * @return Response
     * @throws EditPostException
     */
    public function edit(Request $request, Post $post): Response
    {
        if ($this->getUser() !== $post->getAuthor()) {
            throw new EditPostException('Vous n\'etes pas l\'auteur de cet article.');
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'l\'article a bien ete edite');

            return $this->redirectToRoute('app_read_post', ['slug' => $post->getSlug()]);
        }

        return $this->render('admin/posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * The method that is executed when the user performs a 'delete' action to
     * remove any entity.
     *
     * @return RedirectResponse
     *
     * @throws EntityRemoveException
     * @throws Exception
     */
    protected function deleteAction(): RedirectResponse
    {
        $this->dispatch(EasyAdminEvents::PRE_DELETE);

        if ('DELETE' !== $this->request->getMethod()) {
            return $this->redirect($this->generateUrl('easyadmin', ['action' => 'list', 'entity' => $this->entity['name']]));
        }

        $id = $this->request->query->get('id');
        $form = $this->createDeleteForm($this->entity['name'], $id);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $easyadmin = $this->request->attributes->get('easyadmin');
            $entity = $easyadmin['item'];

            $this->dispatch(EasyAdminEvents::PRE_REMOVE, ['entity' => $entity]);

            /** @var Post $entity */
            $deleted = $entity->getDeleted() === null ? new DateTime('now') : null;

            $entity->setDeleted($deleted);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->dispatch(EasyAdminEvents::POST_REMOVE, ['entity' => $entity]);
        }

        $this->dispatch(EasyAdminEvents::POST_DELETE);

        return $this->redirectToReferrer();
    }
}