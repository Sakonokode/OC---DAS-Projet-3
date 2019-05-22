<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Seance;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class SeanceController
 * @package App\Controller
 */
class SeanceController extends BaseAdminController
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
        $seances = $this->entityManager->getRepository(Seance::class)->findByDate();

        return new Response($this->renderView('movies/index.html.twig', [
            'seances' => $seances,
        ]));
    }
}