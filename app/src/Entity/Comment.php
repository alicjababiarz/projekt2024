<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string',length: 64)]
    private ?string $email = null;

    #[ORM\Column(type: 'string',length: 64)]
    private ?string $nick = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: Element::class, fetch:'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Element $element = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     * @return $this
     */
    public function setNick(string $nick): static
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Element|null
     */
    public function getElement(): ?Element
    {
        return $this->element;
    }

    /**
     * @param Element|null $element
     * @return $this
     */
    public function setElement(?Element $element): static
    {
        $this->element = $element;

        return $this;
    }
}
