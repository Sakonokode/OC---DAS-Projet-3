<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Seance;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends AbstractController
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