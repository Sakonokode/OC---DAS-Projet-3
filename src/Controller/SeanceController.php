<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Seance;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SeanceController
 * @package App\Controller
 */
class SeanceController extends AbstractController
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
     * @Route("/seances", name="app_seances")
     * @return Response
     * @throws Exception
     */
    public function list(): Response
    {
        $seances = $this->entityManager->getRepository(Seance::class)->findByDate(new DateTime('now'));
        dump($seances);
        return new Response($this->renderView('movies/index.html.twig', ['seances' => $seances]));
    }
}