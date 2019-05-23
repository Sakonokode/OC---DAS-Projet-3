<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Trait CommentableTrait
 * @package App\Traits
 */
trait CommentableTrait
{
    /**
     * @var Comment[]|ArrayCollection $comments
     * @ORM\ManyToMany(targetEntity="App\Entity\Comment")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="entity_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"created" = "DESC"})
     */
    protected $comments;

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection|Comment[] $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment): void
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }
}