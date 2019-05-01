<?php


namespace App\Controller;


use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends Controller
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/movies", name="movies")
     * @return Response
     */
    public function listMovies(): Response
    {
        $latestMovies = $this->entityManager->getRepository(Movie::class)->findAll();

        return $this->render('movies/index.html.twig', ['movies' => $latestMovies]);
    }
}