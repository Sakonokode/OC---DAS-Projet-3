<?php


namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait MediaTrait
 * @package App\Traits
 */
trait MediaTrait
{
    use EntityTrait;
    use DescribableTrait;

    /**
     * @var null|DateTime $date
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $duration;

    /**
     * @var string $url
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     */
    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return string|null ?string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}