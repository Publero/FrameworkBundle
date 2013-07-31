<?php
namespace Publero\FrameworkBundle\ORM;

use Doctrine\ORM\EntityRepository as BaseRepository;

class EntityRepository extends BaseRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return int
     */
    public function countBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return count($this->findBy($criteria, $orderBy, $limit, $offset));
    }

    /**
     * @param string $alias
     * @return \Publero\FrameworkBundle\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias)
    {
        $qb = new \Publero\FrameworkBundle\ORM\QueryBuilder($this->_em);
        $qb
            ->select($alias)
            ->from($this->_entityName, $alias)
        ;

        return $qb;
    }
}