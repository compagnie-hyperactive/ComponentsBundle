<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 05/05/17
 * Time: 10:20
 */

namespace Lch\ComponentsBundle\Behavior;


use Doctrine\ORM\QueryBuilder;

trait PaginableRepository
{
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
}