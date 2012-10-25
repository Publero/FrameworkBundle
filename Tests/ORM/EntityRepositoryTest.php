<?php
namespace Publero\FrameworkBundle\Tests\ORM;

use Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository;

class EntityRepositoryTest extends ORMTestCase
{
    public function testGetEntityRepositoryFromEntityManager()
    {
        $this->assertInstanceOf('\Publero\FrameworkBundle\ORM\EntityRepository', $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository'));
        $this->assertInstanceOf('\Publero\FrameworkBundle\ORM\EntityRepository', $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository'));

        $this->assertNotInstanceOf('\Publero\FrameworkBundle\Tests\ORM\Entity\CustomRepository', $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository'));
        $this->assertInstanceOf('\Publero\FrameworkBundle\Tests\ORM\Entity\CustomRepository', $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository'));
    }

    public function testCreateQueryBuilder()
    {
        $repo = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository');
        $this->assertInstanceOf('\Publero\FrameworkBundle\ORM\QueryBuilder', $repo->createQueryBuilder('entity'));

        $repo = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository');
        $this->assertInstanceOf('\Publero\FrameworkBundle\ORM\QueryBuilder', $repo->createQueryBuilder('entity'));
    }

    public function testCountByEntityWithDefaultRepository()
    {
        $repo = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository');

        $count = $repo->countBy([]);
        $this->assertEquals(5, $count);

        $count = $repo->countBy(['title' => 'Title 1']);
        $this->assertEquals(1, $count);

        $count = $repo->countBy(['title' => 'Titles']);
        $this->assertEquals(2, $count);
    }

    public function testCountByEntityWithCustomRepository()
    {
        $repo = $this->_em->getRepository('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository');

        $count = $repo->countBy([]);
        $this->assertEquals(5, $count);

        $count = $repo->countBy(['title' => 'Title 1']);
        $this->assertEquals(1, $count);

        $count = $repo->countBy(['title' => 'Titles']);
        $this->assertEquals(2, $count);
    }
}
