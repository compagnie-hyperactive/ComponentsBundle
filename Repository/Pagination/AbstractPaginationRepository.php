<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 09/05/17
 * Time: 15:42
 */

namespace Lch\ComponentsBundle\Repository\Pagination;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class AbstractPaginationRepository extends EntityRepository
{
    /**
     * @param $alias
     * @return QueryBuilder
     */
    public function startQueryBuilder($alias) {
        return $this->createQueryBuilder($alias);
    }

    public function addCommonElements(QueryBuilder $qb, array $parameters = []) {
        $qb
            ->addOrderBy("{$qb->getRootAliases()[0]}.id",'DESC')
        ;
        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param int $page
     * @param int $maxPerPage
     * @return $this
     */
    public function addPaginationElements(QueryBuilder $qb, int $page, int $maxPerPage) {
        return $qb
            ->setFirstResult(($page-1) * $maxPerPage)
            ->setMaxResults($maxPerPage)
            ;
    }

    /**
     * @param QueryBuilder $qb
     * @param int $page
     * @param int $maxPerPage
     * @return Paginator
     */
    public function getListPaginated(QueryBuilder $qb, int $page, int $maxPerPage) {
        $qb
            ->setFirstResult(($page-1) * $maxPerPage)
            ->setMaxResults($maxPerPage)
        ;

        $paginator = new Paginator($qb);
        return $paginator;
    }


    /**
     * @param string $alias
     * @param array $parameters
     * @return QueryBuilder
     */
    public function startFindPublishedQueryBuilder($alias, $parameters = []) {
        return $this->addCommonElements($this->createQueryBuilder($alias), $parameters);
    }

    /**
     * @param array $parameters
     * @param string $alias
     * @return QueryBuilder
     */
    public function startCountTotalPublishedQueryBuilder($alias, $parameters = []) {
        $qb = $this
            ->addCommonElements($this->startQueryBuilder($alias), $parameters)
            ->select("count($alias.id)")
        ;

        return $qb;
    }
}