<?php

declare(strict_types=1);

namespace App\Twig;


use App\Entity\Movie;
use App\Entity\Seance;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
     * @param User $user
     * @param Movie $movie
     * @return Subscription|mixed|null
     * @throws NonUniqueResultException
     */
    public function getSubscription(User $user, Movie $movie)
    {
        $repository = $this->manager->getRepository(Subscription::class);

        return $repository->getSubscription($user, $movie);
    }
}