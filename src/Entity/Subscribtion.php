<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\EntityTrait;

/**
 * Class Subscribtion
 * @package App\Entity
 * @ORM\Table("subscriptions")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscribtion
{
    use EntityTrait;

    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $user;

    /**
     * @var Media|Movie $media
     * @ORM\ManyToOne(targetEntity="App\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $media;

    /**
     * Subscribtion constructor.
     * @param User $user
     * @param Media $media
     */
    public function __construct(User $user, Media $media)
    {
        $this->user = $user;
        $this->media = $media;
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
     * @return Media|Movie
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media|Movie $media
     */
    public function setMedia($media): void
    {
        $this->media = $media;
    }
}