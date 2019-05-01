<?php


namespace App\Repository;

use App\Entity\Subscribtion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subscribtion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscribtion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscribtion[]    findAll()
 * @method Subscribtion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    /**
     * MovieRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscribtion::class);
    }

}