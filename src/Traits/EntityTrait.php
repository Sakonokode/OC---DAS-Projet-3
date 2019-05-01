<?php


namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EntityTrait
 * @package App\Traits
 * @ORM\HasLifecycleCallbacks()
 */
trait EntityTrait
{
    /**
     * @var int $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var DateTime $updated
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @var null|DateTime $deleted
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @throws \Exception
     */
    public function autoUpdateDates(): void
    {
        if ($this->created === null) {
            $this->created = new DateTime('NOW');
        }

        $this->updated = new DateTime('NOW');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return DateTime|null
     */
    public function getDeleted(): ?DateTime
    {
        return $this->deleted;
    }

    /**
     * @param DateTime|null $deleted
     */
    public function setDeleted(?DateTime $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->id;
    }
}