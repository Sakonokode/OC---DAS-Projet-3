<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\MediaTrait;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Media
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "movie" = "App\Entity\Movie"})
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Media
{
    use MediaTrait;

    /**
     * @var null|string $author
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * @return null|string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
}