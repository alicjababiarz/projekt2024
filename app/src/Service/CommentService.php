<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use App\Repository\CommentRepository;

/**
 *
 */
class CommentService implements CommentServiceInterface
{

    private CommentRepository $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param string $email
     * @param string $nick
     * @param string $content
     * @param Element $element
     * @return Comment
     */
    public function createComment(string $email, string $nick, string $content, Element $element): Comment
    {
        $comment = new Comment();
        $comment->setEmail($email)
            ->setNick($nick)
            ->setContent($content)
            ->setElement($element);

        $this->commentRepository->save($comment);

        return $comment;
    }

    /**
     * @param Comment $comment
     * @return void
     */
    public function save(Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->commentRepository->findAll();
    }
}
