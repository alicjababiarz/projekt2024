<?php

/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Comment service interface.
 */
interface CommentServiceInterface
{
    /**
     * Save entity.
     *
     * @param Comment $comment  Comment entity
     *
     * @return void
     */
    public function save(Comment $comment): void;

    /**
     * Remove entity.
     *
     * @param Comment $comment  Comment entity
     *
     * @return void
     */
    public function remove(Comment $comment): void;

    /**
     * Find all comments.
     *
     * @return array  Array of comments
     */
    public function findAll(): array;

    /**
     * Get paginated list.
     *
     * @param int     $page     Page number
     * @param Element $element  Element entity
     *
     * @return PaginationInterface  Paginated list of comments
     */
    public function getPaginatedList(int $page, Element $element): PaginationInterface;
}
