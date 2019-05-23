<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Seance;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class SeanceRepository
 *
 * @method Seance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seance[]    findAll()
 * @method Seance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Repository
 */
class SeanceRepository extends ServiceEntityRepository
{
    /** @var DateTime $start */
    private $start;

    /** @var DateTime $end */
    private $end;

    /**
     * MovieRepository constructor.
     * @param RegistryInterface $registry
     * @throws Exception
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Seance::class);

        $date = new DateTime('now');
        $this->start = clone $date;
        $this->start->setTime(0, 0);
        $this->end = clone $date;
        $this->end->setTime(23, 59, 59);
    }

    /**
     * @return array
     */
    public function findByDate(): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.date >= :start and s.date < :end')
            ->setParameters([
                'start' => $this->start,
                'end' => $this->end
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function findMovies(): array
    {
        $startDate = $this->start->format('Y-m-d H:i:s');
        $endDate = $this->end->format('Y-m-d H:i:s');

        $sql = <<<SQL
        SELECT *
        FROM seance
        LEFT JOIN media ON seance.media_id = media.id
        WHERE seance.date BETWEEN :startDate AND :endDate
        AND discr='movie'
        AND media.deleted IS NULL
SQL;

        $rsm = new ResultSetMapping();

        $properties = [
            'id',
            'date',
            'duration',
            'title',
            'author',
            'content',
            'slug',
        ];

        $rsm->addEntityResult(Movie::class, 'movie');
        foreach ($properties as $property) {
            $rsm->addFieldResult('movie', $property, $property);
        }

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameters([
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return $query->getResult();
    }

    /**
     * @param Movie $movie
     * @return Seance|null
     * @throws Exception
     */
    public function findNext(Movie $movie): ?Seance
    {
        $now = new DateTime('now');

        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.date >= :now')
            ->andWhere('s.media = :movie')
            ->orderBy('s.date', 'asc')
            ->setParameters([
                'now' => $now,
                'movie' => $movie
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}