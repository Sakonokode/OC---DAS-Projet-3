<?php


namespace App\Repository;

use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Seance;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class SubscriptionRepository
 *
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Repository
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * SubscriptionRepository constructor.
     * @param RegistryInterface $registry
     * @param EntityManagerInterface $em
     */
    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Subscription::class);
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param Media|null $media
     * @return null|mixed
     */
    public function getSubscriptions(User $user, Media $media = null): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.user = :user')
            ->leftJoin('s.seance', 'sc')
            ->setParameters([
                'user' => $user
            ]);

        if ($media !== null) {
            $qb->andWhere('sc.media = :movie')
                ->setParameter('media', $media);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @param Media|null $media
     * @return array
     */
    public function getMediaSubscriptions(User $user, Media $media = null): array
    {
        $sql =<<<SQL
        SELECT m.id AS mid, m.title, sc.id AS scid, sc.date
        FROM media AS m
        RIGHT JOIN seance AS sc ON sc.media_id = m.id
        RIGHT JOIN subscriptions AS s ON s.seance_id = sc.id
        LEFT JOIN users AS u ON s.user_id = u.id
        WHERE u.id = :user
        AND s.active = 1
SQL;

        if ($media !== null) {
            $sql .=<<<SQL
        AND m.id = :media
SQL;
        }

        $sql .=<<<SQL
        ORDER BY mid, scid ASC
SQL;

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Movie::class, 'mid');
        $rsm->addFieldResult('mid', 'mid', 'id');
        $rsm->addFieldResult('mid', 'title', 'title');

        $rsm->addEntityResult(Seance::class, 'scid');
        $rsm->addFieldResult('scid', 'scid', 'id');
        $rsm->addFieldResult('scid', 'date', 'date');

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter('user', $user);
        if ($media !== null) {
            $query->setParameter('media', $media);
        }

        $results = $query->getResult();

        $tmp = [];
        $currentMedia = null;
        foreach ($results as $index => $entity) {
            if ($entity instanceof Media && !isset($tmp[$entity->getId()])) {
                /** @var Media $entity */
                $tmp[$entity->getId()] = [];
                $currentMedia = $entity;
                $this->em->detach($entity);
                continue;
            }

            /** @var Seance $entity */
            $tmp[$currentMedia->getId()][] = $entity;
        }

        return $tmp;
    }


}