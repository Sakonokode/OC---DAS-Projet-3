<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Movie
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Movie extends Media
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }
}