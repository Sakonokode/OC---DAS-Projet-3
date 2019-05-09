<?php


namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    /**
     * MovieRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * @param User $user
     * @param Movie $movie
     * @return null|mixed
     * @throws NonUniqueResultException
     */
    public function getSubscription(User $user, Movie $movie): ?Subscription
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.user = :user')
            ->leftJoin('s.seance', 'sc')
            ->andWhere('sc.media = :movie')
            ->setParameters([
                'user' => $user,
                'movie' => $movie
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}