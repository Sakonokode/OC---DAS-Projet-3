<?php


namespace App\Entity;


use App\Traits\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    use EntityTrait;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="comment.blank")
     * @Assert\Length(
     *     min=5,
     *     minMessage="comment.too_short",
     *     max=10000,
     *     maxMessage="comment.too_long"
     * )
     */
    private $content;

    /**
     * @var User $author
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * One Comment has Many Comments/Answers.
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="parent")
     */
    private $children;

    /**
     * Many Answers/Comments have One Parent.
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="children")
     */
    private $parent;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @param Comment $children
     */
    public function addChildren(Comment $children): void
    {
        if (!$this->children->contains($children)) {
            $this->children->add($children);
        }
    }

    /**
     * @param Comment $children
     */
    public function removeChildren(Comment $children): void
    {
        if ($this->children->contains($children)) {
            $this->children->remove($children);
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children): void
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }
}