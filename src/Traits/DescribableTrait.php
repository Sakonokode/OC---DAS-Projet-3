<?php


namespace App\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait DescribableTrait
 * @package App\Traits
 */
trait DescribableTrait
{
    /**
     * var string $title
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var null|string $description
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }
}