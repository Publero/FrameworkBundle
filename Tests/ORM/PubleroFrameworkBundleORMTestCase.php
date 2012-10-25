<?php
namespace Publero\FrameworkBundle\Tests\ORM;

use Doctrine\Tests\OrmFunctionalTestCase;

class PubleroFrameworkBundleORMTestCase extends OrmFunctionalTestCase
{
    public function setUp()
    {
        $this->initModelSet();
        parent::setUp();
        $this->init();
    }

    public function tearDown()
    {
        $this->clearTables();

        if ($this->_em) {
            $this->_em->getConfiguration()->setEntityNamespaces(array());
        }
        parent::tearDown();
    }

    protected function initModelSet()
    {
        static::$_modelSets['publero_frameworkbundle_orm_test'] = [
            '\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository',
            '\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository',
        ];

        $this->useModelSet('publero_frameworkbundle_orm_test');
    }

    protected function init()
    {
        $this->setConfig();
        $this->loadFixture('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithDefaultRepository');
        $this->loadFixture('\Publero\FrameworkBundle\Tests\ORM\Entity\EntityWithCustomRepository');
    }

    protected function setConfig()
    {
        $this->assertEquals($this->_em->getConfiguration()->getDefaultRepositoryClassName(), "Doctrine\ORM\EntityRepository");
        $this->_em->getConfiguration()->setDefaultRepositoryClassName('\Publero\FrameworkBundle\ORM\EntityRepository');
        $this->assertEquals($this->_em->getConfiguration()->getDefaultRepositoryClassName(), '\Publero\FrameworkBundle\ORM\EntityRepository');
    }

    /**
     * @param string $entityName
     */
    protected function loadFixture($entityName)
    {
        $entity = new $entityName();
        $entity->title = 'Title 1';
        $this->_em->persist($entity);

        $entity = new $entityName();
        $entity->title = 'Title 2';
        $this->_em->persist($entity);

        $entity = new $entityName();
        $entity->title = 'Titles';
        $this->_em->persist($entity);

        $entity = new $entityName();
        $entity->title = 'Titles';
        $this->_em->persist($entity);

        $entity = new $entityName();
        $entity->title = 'Some';
        $this->_em->persist($entity);

        $this->_em->flush();
    }

    protected function clearTables()
    {
        $conn = static::$_sharedConn;

        $conn->executeUpdate('DELETE FROM publero_frameworkbundle_orm_test_custom');
        $conn->executeUpdate('DELETE FROM publero_frameworkbundle_orm_test_default');
    }
}