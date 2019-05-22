<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Seance;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends BaseAdminController
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
     * @Route("/movies", name="app_movies")
     * @return Response
     * @throws Exception
     */
    public function list(): Response
    {
        $movies = $this->entityManager->getRepository(Seance::class)->findMovies();

        return new Response($this->renderView('movies/index.html.twig', [
            'movies' => $movies,
        ]));
    }
}