<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Seance;
use App\Entity\Subscription;
use App\Entity\User;
use App\Exception\SubscriptionException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SubscriptionService
 *
 * @package App\Service
 */
final class SubscriptionService
{
    /**
     * @var EntityManager $manager
     */
    private $manager;

    /**
     * SubscriptionService constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     * @param Seance $seance
     * @return void
     * @throws SubscriptionException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function subscribe(User $user, Seance $seance): void
    {
        $repository = $this->manager->getRepository(Subscription::class);
        $subscription = $repository->findOneBy([
            'user' => $user,
            'media' => $seance->getMedia()
        ]);

        if ($subscription === null) {
            $subscription = new Subscription($user, $seance);
        }

        if (!$seance->updateTotalSubscriptions()) {
            throw new SubscriptionException('app.subscription.error.subscription_failed');
        }

        $subscription->setActive(true);

        $this->manager->persist($subscription);
        $this->manager->persist($seance);
        $this->manager->flush();
    }

    /**
     * @param Subscription $subscription
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function unsubscribe(Subscription $subscription): void
    {
        if ($subscription->isActive()) {
            $subscription->setActive(false);
            $subscription->getSeance()->updateTotalSubscriptions(-1);

            $this->manager->persist($subscription);
            $this->manager->flush();
        }

    }
}