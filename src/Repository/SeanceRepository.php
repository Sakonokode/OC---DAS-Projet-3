<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Seance;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
    /**
     * MovieRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    /**
     * @param DateTime $date
     * @return array
     */
    public function findByDate(DateTime $date): array
    {
        $start = clone $date;
        $start->setTime(0, 0);
        $end = clone $start;
        $end->setTime(23, 59, 59);

        dump($start, $end);

        $qb = $this->createQueryBuilder('s');
        $qb->where('s.date > :start and s.date < :end')->setParameters([
            'start' => $start,
            'end' => $end
        ]);

        return $qb->getQuery()->getResult();
    }
}