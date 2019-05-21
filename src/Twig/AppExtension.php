<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Seance;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 * @package App\Twig
 */
final class AppExtension extends AbstractExtension
{
    /** @var EntityManagerInterface $manager */
    private $manager;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('next_seance', [$this, 'getNextSeance']),
        ];
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_subscription', [$this, 'getSubscription']),
            new TwigFunction('get_movie', [$this, 'getMovie']),
            new TwigFunction('get_movie_by_id', [$this, 'getMovieById']),
            new TwigFunction('get_gmap_api_key', [$this, 'getGmapApiKey']),
        ];
    }

    /**
     * @param Movie $movie
     * @return Seance|null
     * @throws Exception
     */
    public function getNextSeance(Movie $movie): ?Seance
    {
        $repository = $this->manager->getRepository(Seance::class);

        return $repository->findNext($movie);
    }

    /**
     * @param Seance $seance
     * @return Subscription|mixed|null
     */
    public function getSubscription(Seance $seance): ?Subscription
    {
        $repository = $this->manager->getRepository(Subscription::class);

        return $repository->findOneBy([
            'seance' => $seance,
        ]);
    }

    /**
     * @param Subscription $subscription
     * @return Media|null
     */
    public function getMovie(Subscription $subscription): ?Media
    {
        $repository = $this->manager->getRepository(Media::class);

        return $repository->find($subscription->getSeance()->getMedia()->getId());
    }

    /**
     * @param int $id
     * @return Movie|null
     */
    public function getMovieById(int $id): ?Movie
    {
        $repository = $this->manager->getRepository(Movie::class);

        return $repository->find($id);
    }

    /**
     * @return string
     */
    public function getGmapApiKey(): string
    {
        $apiKey = __DIR__ . '/../../../../API-Keys/gmapApiKey.txt';

        return file_get_contents($apiKey);
    }
}