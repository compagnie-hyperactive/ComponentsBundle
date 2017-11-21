<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 09/05/17
 * Time: 15:25
 */

namespace Lch\ComponentsBundle\Manager;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lch\ComponentsBundle\Repository\Pagination\AbstractPaginationRepository;
use Lch\ComponentsBundle\Service\Pagination;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractPaginationManager
{
    const ITEMS = 'items';
    const PAGINATION = 'pagination';

    /**
     * @var AbstractPaginationRepository
     */
    protected $repository;

    /**
     * @var Pagination $pagination
     */
    protected $pagination;

    /**
     * AbstractPaginationManager constructor.
     * @param AbstractPaginationRepository $repository
     * @param Pagination $pagination
     */
    public function __construct(AbstractPaginationRepository $repository, Pagination $pagination) {
        $this->repository = $repository;
        $this->pagination = $pagination;
    }
    

    protected function getPaginationData(QueryBuilder $mainQb, int $page = 1, int $maxPerPage = 20, string $route, array $routeParams = []) {

        $paginationQuery = clone $mainQb;

        $totalItemCount = $paginationQuery
            ->select("count({$mainQb->getRootAliases()[0]})")
            ->resetDqlPart("orderBy")
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $pagination = $this->pagination->getPagination(
            $totalItemCount,
            $page,
            $maxPerPage,
            $route,
            $routeParams
        );

        // Add pagination elements
        $pagination->addPaginationElements($mainQb, $page, $maxPerPage);

        $paginator = new Paginator($mainQb);
        return [
            static::ITEMS => $paginator,
            static::PAGINATION => $pagination
        ];
    }
}