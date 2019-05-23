<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

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
}