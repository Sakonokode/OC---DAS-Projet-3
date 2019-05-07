<?php


namespace App\Controller;

use App\Entity\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediaController
 * @package App\Controller
 */
class MediaController extends Controller
{
    /**
     * @Route("/movie/play/{slug}", name="play")
     * @param Media $media
     * @return Response
     */
    public function play(Media $media): Response
    {
        return $this->render('movies/read.html.twig', ['media' => $media]);
    }
}