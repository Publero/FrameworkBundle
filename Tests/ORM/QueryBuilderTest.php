<?php
namespace Publero\FrameworkBundle\Tests\ORM;

class QueryBuilderTest extends ORMTestCase
{
    public function testGetCountAndTotal()
    {
        $qb = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository')->createQueryBuilder('entity');

        $qb->where($qb->expr()->like('entity.title', $qb->expr()->literal('%Title%')));
        $this->assertEquals(4, $qb->getCount());

        $qb->where($qb->expr()->like('entity.title', $qb->expr()->literal('%Titles%')));
        $this->assertEquals(2, $qb->getCount());

        $qb
            ->setFirstResult(1)
            ->setMaxResults(1)
        ;
        $this->assertEquals(2, $qb->getCount());
    }

    public function testGetTotalEntityWithDefaultRepository()
    {
        $qb = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository')->createQueryBuilder('entity');

        $qb->where($qb->expr()->like('entity.title', $qb->expr()->literal('%Title%')));
        $this->assertEquals(4, $qb->getCount());
        $this->assertEquals(5, $qb->getTotal());

        $qb->where($qb->expr()->like('entity.title', $qb->expr()->literal('%Titles%')));
        $this->assertEquals(2, $qb->getCount());
        $this->assertEquals(5, $qb->getTotal());

        $qb
            ->setFirstResult(1)
            ->setMaxResults(1)
        ;
        $this->assertCount(1,$qb->getQuery()->getResult());
        $this->assertEquals(2, $qb->getCount());
        $this->assertEquals(5, $qb->getTotal());
    }
}
