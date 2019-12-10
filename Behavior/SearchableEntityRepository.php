<?php

namespace Lch\ComponentsBundle\Behavior;

use Doctrine\ORM\QueryBuilder;

/**
 * Trait SearchableEntityRepository
 *
 * @package App\Repository\Traits
 */
trait SearchableEntityRepository
{
    /**
     * @param array $fields
     * @param string $term
     * @param string|null $language
     *
     * @return array
     */
    public function findByFulltextTerm(
        array $fields,
        string $term,
        string $language = null
    ): array {
        /** @var QueryBuilder $qb */
        $qb = $this->_em->createQueryBuilder();


        $firstField = array_shift($fields);
        $qb
            ->select("entity.$firstField")
            ->from($this->getClassName(), 'entity');

        foreach ($fields as $field) {
            $qb->addSelect("entity.$field");
            $qb->orWhere($qb->expr()->like("entity.$field", ':term'));
        }
        $qb->setParameter('term', "%$term%");

        $qb->setMaxResults(100);

        if (null !== $language && ! empty($language)) {
            $qb->andWhere('entity.language = :language');
            $qb->setParameter('language', $language);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $linkedEntities
     * @param string $term
     * @param string|null $language
     *
     * @return array
     */
    public function findByRelationEntity(
        array $linkedEntities,
        string $term,
        string $language = null
    ): array {
        /** @var QueryBuilder $qb */
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('entity.id')
            ->from($this->getClassName(), 'entity');

        foreach ($linkedEntities as $field => $entityData) {
            $subFieldName = "{$field}.{$entityData['field']}";
            $qb
                ->join("entity.{$field}", $field)
                ->addSelect($subFieldName)
                ->orWhere($qb->expr()->like($subFieldName, ":term"));;
        }
        $qb->setParameter('term', "%$term%");

        $qb->setMaxResults(100);

        if (null !== $language && ! empty($language)) {
            $qb->andWhere('entity.language = :language');
            $qb->setParameter('language', $language);
        }

        return $qb->getQuery()->getResult();
    }
}
