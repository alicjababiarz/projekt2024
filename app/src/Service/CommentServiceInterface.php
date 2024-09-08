<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
     * @param Comment $comment
     * @return void
     */
    public function delete(Comment $comment): void;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param int $page
     * @param $element
     * @return mixed
     */
    public function getPaginatedList(int $page, Element $element): PaginationInterface;

}
