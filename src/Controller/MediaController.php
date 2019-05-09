<?php


namespace App\Controller;

use App\Entity\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MediaController
 * @package App\Controller
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/movie/read/{slug}", name="app_read")
     * @param Media $media
     * @return Response
     */
    public function read(Media $media): Response
    {
        return new Response($this->renderView('movies/read.html.twig', ['media' => $media]));
    }
}