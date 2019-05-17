<?php


namespace App\Controller;

use App\Entity\Media;
use App\Entity\Seance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MediaController
 * @package App\Controller
 */
class MediaController extends AbstractController
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
     * @Route("/movie/read/{slug}", name="app_read")
     * @param Media $media
     * @return Response
     */
    public function read(Media $media): Response
    {
        $repository = $this->entityManager->getRepository(Seance::class);
        $seances = $repository->findBy(['media' => $media]);

        return new Response($this->renderView('movies/read.html.twig', [
            'media' => $media,
            'seances' => $seances
        ]));
    }
}