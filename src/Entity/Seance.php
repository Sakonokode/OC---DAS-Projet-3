<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityTrait;
use Datetime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Seance
 *
 * @ORM\Entity(repositoryClass="App\Repository\SeanceRepository")
 * @ORM\HasLifecycleCallbacks()
 * @package App\Entity
 */
class Seance
{
    use EntityTrait;

    /**
     * @var Datetime $date
     *
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @var Media|Movie $media
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $media;

    /**
     * @var int $totalSubscriptions
     * @ORM\Column(type="integer")
     */
    protected $totalSubscriptions = 0;

    /**
     * @var int $maxSubscriptions
     * @ORM\Column(type="integer")
     */
    protected $maxSubscriptions = 0;

    /**
     * @return Datetime
     */
    public function getDate(): Datetime
    {
        return $this->date;
    }

    /**
     * @param Datetime $date
     */
    public function setDate(Datetime $date): void
    {
        $this->date = $date;
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

    /**
     * @return int
     */
    public function getTotalSubscriptions(): int
    {
        return $this->totalSubscriptions;
    }

    /**
     * @param int $totalSubscriptions
     */
    public function setTotalSubscriptions(int $totalSubscriptions): void
    {
        $this->totalSubscriptions = $totalSubscriptions;
    }

    /**
     * @return int
     */
    public function getMaxSubscriptions(): int
    {
        return $this->maxSubscriptions;
    }

    /**
     * @param int $maxSubscriptions
     */
    public function setMaxSubscriptions(int $maxSubscriptions): void
    {
        $this->maxSubscriptions = $maxSubscriptions;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return ($this->maxSubscriptions - $this->totalSubscriptions > 0);
    }

    /**
     * @param int $value
     * @return bool
     */
    public function updateTotalSubscriptions(int $value = 1): bool
    {
        if ($this->totalSubscriptions === 0 && $value === -1) {
            return true;
        }

        if ($this->totalSubscriptions >= 0 && $this->totalSubscriptions < $this->maxSubscriptions) {
            $this->totalSubscriptions += $value;

            return true;
        }

        return false;
    }
}