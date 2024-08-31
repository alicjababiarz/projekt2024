<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;

/**
 *
 */
interface CommentServiceInterface
{
    /**
     * @param string $email
     * @param string $nick
     * @param string $content
     * @param Element $element
     * @return Comment
     */
    public function createComment(string $email, string $nick, string $content, Element $element): Comment;

    /**
     * @param Comment $comment
     * @return void
     */
    public function save(Comment $comment): void;

    /**
     * @return array
     */
    public function findAll(): array;

}
