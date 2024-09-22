<?php

/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Comment service interface
 */
interface CommentServiceInterface
{
    /**
     * @param Comment $comment
     * @return void
     */
    public function save(Comment $comment): void;

    /**
     * @param Comment $comment
     * @return void
     */
    public function remove(Comment $comment): void;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param int $page
     * @param Element $element
     * @return mixed
     */
    public function getPaginatedList(int $page, Element $element): PaginationInterface;
}
