<?php
namespace Publero\FrameworkBundle\ORM;

use Doctrine\ORM\QueryBuilder as BaseBuilder;

class QueryBuilder extends BaseBuilder
{
    /**
     * @return int
     */
    public function getCount()
    {
        $qb = clone($this);
        $qb->prepareForCount();

        return $qb->returnCount();
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        $qb = clone($this);
        $qb->prepareForTotal();
        $qb->getParameters()->clear();

        return $qb->returnCount();
    }

    private function prepareForCount()
    {
        $alias = $this->getDQLPart('from')[0]->getAlias();

        $this
            ->select("count($alias)")
            ->setMaxResults(null)
            ->setFirstResult(null)
            ->resetDQLPart('orderBy')
        ;
    }

    private function prepareForTotal()
    {
        $this->prepareForCount();
        $this->resetDQLPart('where');
    }

    /**
     * @return int
     */
    private function returnCount()
    {
        return (int) $this
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
