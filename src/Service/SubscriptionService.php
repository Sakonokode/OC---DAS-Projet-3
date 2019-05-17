<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Media;
use App\Entity\Seance;
use App\Entity\Subscription;
use App\Entity\User;
use App\Exception\SubscriptionException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SubscriptionService
 *
 * @package App\Service
 */
final class SubscriptionService
{
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * SubscriptionService constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     * @param Seance $seance
     * @return void
     * @throws SubscriptionException
     */
    public function subscribe(User $user, Seance $seance): void
    {
        $repository = $this->manager->getRepository(Subscription::class);
        $subscription = $repository->findOneBy([
            'user' => $user,
            'seance' => $seance
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
     * @param User $user
     * @param Seance $seance
     * @return void
     */
    public function unsubscribe(User $user, Seance $seance): void
    {
        $repository = $this->manager->getRepository(Subscription::class);
        $subscription = $repository->findOneBy([
            'user' => $user,
            'seance' => $seance
        ]);

        if ($subscription !== null && $subscription->isActive()) {
            $subscription->setActive(false);
            $subscription->getSeance()->updateTotalSubscriptions(-1);

            $this->manager->persist($subscription);
            $this->manager->flush();
        }
    }

    /**
     * @param User $user
     * @param Media|null $media
     * @return array|null
     */
    public function getSubscriptions(User $user, Media $media = null): ?array
    {
        $repository = $this->manager->getRepository(Subscription::class);

        return $repository->getSubscriptions($user, $media);
    }
}