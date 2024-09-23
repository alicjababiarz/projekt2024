<?php

/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Comment service.
 */
class CommentService implements CommentServiceInterface
{
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    private CommentRepository $commentRepository;

    /**
     * Constructor.
     *
     * @param CommentRepository    $commentRepository  Comment repository
     * @param PaginatorInterface   $paginator          Paginator
     */
    public function __construct(CommentRepository $commentRepository, private readonly PaginatorInterface $paginator)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Save entity.
     *
     * @param Comment $comment  Comment entity
     *
     * @return void
     */
    public function save(Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    /**
     * Remove entity.
     *
     * @param Comment $comment  Comment entity
     *
     * @return void
     */
    public function remove(Comment $comment): void
    {
        $this->commentRepository->remove($comment);
        $this->commentRepository->flush();
    }

    /**
     * Find all comments.
     *
     * @return array  Array of comments
     */
    public function findAll(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * Get paginated list.
     *
     * @param int     $page     Page number
     * @param Element $element  Element entity
     *
     * @return PaginationInterface  Paginated list of comments
     */
    public function getPaginatedList(int $page, Element $element): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findBy(['element' => $element]),
            $page ?? 1,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
