<?php

namespace Lch\ComponentsBundle\Behavior;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait PaginableEntityRepository
 *
 * @package App\Repository\Traits
 */
trait PaginableEntityRepository
{
    /**
     * @param int $page
     * @param int|null $maxResults
     * @param array $criteria
     * @param array $orderBy
     * @param bool $getPaginator
     * @param string $discriminatorValue
     *
     * @return array|Paginator
     */
    public function getPaginatedList(
        int $page = 1,
        int $maxResults = null,
        array $criteria = [],
        array $orderBy = [],
        bool $getPaginator = false,
        string $discriminatorValue = ""
    ) {

        $this->checkBoundariesValues($page, $maxResults);

        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('entity');
        $qb->select('entity');


        // Filtering query
        if (! empty($criteria)) {
            $i = 0;
            $j = 0;
            foreach ($criteria as $field => $value) {
                $alias = 'c_' . $i++;

                // TODO refactor and document
                if (is_array($value)) {
                    if (isset($value['type']) && $value['data']) {
                        switch ($value['type']) {
                            case 'LIKE':
                                $qb
                                    ->andWhere("entity.$field LIKE :$alias")
                                    ->setParameter($alias, "%{$value['data']}%");
                                break;
                            case 'OR':
                                $orExp = $qb->expr()->orX();
                                if (is_array($value['data'])) {
                                    foreach ($value['data'] as $key => $fieldValue) {
                                        $alias .= "_" . $j++;
                                        $orExp->add("entity.$key LIKE :$alias");
                                        $qb->setParameter($alias, "%{$fieldValue}%");
                                    }
                                    $qb->andWhere($orExp);
                                }
                        }
                    }
                } else {
                    $qb
                        ->andWhere("entity.$field = :$alias")
                        ->setParameter($alias, $value);
                }
            }
        }
        if (! empty($discriminatorValue)) {
            $qb
                ->andWhere('entity INSTANCE OF :discriminator')
                ->setParameter('discriminator', $discriminatorValue);
        }

        // Ordering query
        if (! empty($orderBy)) {
            foreach ($orderBy as $field => $order) {
                if (! in_array(strtolower($order), ['desc', 'asc'], true)) {
                    throw new \UnexpectedValueException(
                        "Order must be ASC or DESC, \"$order\" given."
                    );
                }
                $qb->addOrderBy("entity.$field", $order);
            }
        }

        // Returning results if paginator is not needed
        if ($getPaginator === false) {
            return $qb->getQuery()->getResult();
        }

        return $this->getPaginator($qb, $page, $maxResults);
    }

    /**
     * @param int $page
     * @param int|null $maxResults
     */
    protected function checkBoundariesValues(int $page = 1, int $maxResults = null): void
    {
        if ($page < 1) {
            throw new \UnexpectedValueException(
                'Requested page must be positive integer.'
            );
        }

        if ($maxResults && $maxResults < 1) {
            throw new \UnexpectedValueException(
                'Max results must be positive integer.'
            );
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param int $page
     * @param int|null $maxResults
     *
     * @return Paginator
     */
    protected function getPaginator(QueryBuilder $qb, int $page = 1, int $maxResults = null): Paginator
    {
        // Calculating offset
        $firstResult = ($page - 1) * ($maxResults ?: 1);
        $qb->setFirstResult($firstResult);

        // Limiting query
        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        // Returning paginator
        $paginator = new Paginator($qb);
        if (($paginator->count() <= $firstResult) && $page !== 1) {
            throw new NotFoundHttpException('Requested page does not exist.');
        }

        return $paginator;
    }
}
