<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Element;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 *
 */
class CommentService implements CommentServiceInterface
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;
    private CommentRepository $commentRepository;


    /**
     * @param CommentRepository $commentRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(CommentRepository $commentRepository, private readonly PaginatorInterface $paginator)
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
     * @param Comment $comment
     * @return void
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * @param int $page
     * @param $element
     * @return mixed
     */
    public function getPaginatedList(int $page, Element $element): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findBy(['element'=>$element]),
            $page ?? 1,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
