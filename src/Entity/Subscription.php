<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\EntityTrait;

/**
 * Class Subscription
 *
 * @package App\Entity
 * @ORM\Table("subscriptions")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription
{
    use EntityTrait;

    /**
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    protected $user;

    /**
     * @var Seance $seance
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Seance")
     * @ORM\JoinColumn(name="seance_id", referencedColumnName="id")
     */
    protected $seance;

    /**
     * @var bool $active
     * @ORM\Column(type="boolean")
     */
    protected $active = true;

    /**
     * Subscription constructor.
     * @param User $user
     * @param Seance $seance
     */
    public function __construct(User $user, Seance $seance)
    {
        $this->user = $user;
        $this->seance = $seance;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Seance
     */
    public function getSeance(): Seance
    {
        return $this->seance;
    }

    /**
     * @param Seance $seance
     */
    public function setSeance(Seance $seance): void
    {
        $this->seance = $seance;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}