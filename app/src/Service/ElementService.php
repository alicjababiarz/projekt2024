<?php
/**
 * Element service.
 */

namespace App\Service;

use App\Entity\Element;
use App\Repository\ElementRepository;
use Doctrine\ORM\Exception\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ElementService.
 */
class ElementService implements ElementServiceInterface
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ElementRepository  $elementRepository Element repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(private readonly ElementRepository $elementRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->elementRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Element $element Element entity
     *
     * @throws ORMException
     */
    public function save(Element $element): void
    {
        $this->elementRepository->save($element);
    }

    /**
     * Delete entity.
     *
     * @param Element $element Element entity
     *
     * @throws ORMException
     */
    public function delete(Element $element): void
    {
        $this->elementRepository->delete($element);
    }
}
