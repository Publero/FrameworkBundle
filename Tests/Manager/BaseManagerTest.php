<?php
namespace Publero\FrameworkBundle\Tests\Manager;

use Publero\FrameworkBundle\Manager\BaseManager;

class BaseManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrineMock;

    /**
     * @var BaseManager
     */
    private $manager;

    public function setUp()
    {
        $this->doctrineMock = $this
            ->getMockBuilder('\Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->manager = new BaseManager();
        $this->manager->setDoctrine($this->doctrineMock);
    }

    public function testGetDoctrine()
    {
        $this->assertSame($this->doctrineMock, $this->manager->getDoctrine());
    }

    public function testGetEntityManager()
    {
        $object = new \stdClass;

        $this->doctrineMock
            ->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($object))
        ;

        $this->assertSame($object, $this->manager->getEntityManager());
    }

    public function testGetRepository()
    {
        $persistentObjectName = 'persistentObjectName';
        $persistentManagerName = 'persistentManagerName';

        $this->doctrineMock
            ->expects($this->once())
            ->method('getRepository')
            ->with($persistentObjectName, $persistentManagerName)
        ;

        $this->manager->getRepository($persistentObjectName, $persistentManagerName);
    }
}