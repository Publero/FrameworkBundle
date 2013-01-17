<?php
namespace Publero\FrameworkBundle\Tests\Form\Handler;

use Publero\FrameworkBundle\Form\Handler\BaseHandler;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

class BaseHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Symfony\Component\Form\Form
     */
    private $formMock = null;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var BaseHandler
     */
    private $handler;

    public function setUp()
    {
        $this->formMock = $this
            ->getMockBuilder('Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->request = new Request();
        $this->handler = new BaseHandler($this->formMock);
        $this->handler->setRequest($this->request);
    }

    public function testConstructor()
    {
        $handler = new BaseHandler();

        $this->assertNull($handler->getForm());
        $this->assertNull($handler->getFormType());

        $handler = new BaseHandler($this->formMock);

        $this->assertSame($this->formMock, $handler->getForm());
        $this->assertNull($handler->getFormType());

        $type = new FormType();
        $handler = new BaseHandler($type);

        // form would not be null, because handler would try to create it from type
        $this->assertSame($type, $handler->getFormType());
    }

    public function testIsToBeProcessed()
    {
        $this->assertFalse($this->handler->isToBeProcessed());

        $this->request->setMethod('POST');

        $this->assertTrue($this->handler->isToBeProcessed());

        $this->request->setMethod('post');

        $this->assertTrue($this->handler->isToBeProcessed());

        $this->request->setMethod('GET');

        $this->assertFalse($this->handler->isToBeProcessed());
    }

    public function testProcessCallsOnValidMethodIfIsToBeProcessedIsTrue()
    {
        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->handler->process());
    }

    public function testProcessCallsOnInvalidMethodIfIsToBeProcessedIsFalse()
    {
        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false))
        ;

        $this->assertFalse($this->handler->process());
    }

    public function testGetAndSetEventDispatcher()
    {
        $this->assertNull($this->handler->getEventDispatcher());

        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        $this->handler->setEventDispatcher($eventDispatcher);

        $this->assertSame($eventDispatcher, $this->handler->getEventDispatcher());
    }

    public function testSetAndGetForm()
    {
        $this->assertSame($this->formMock, $this->handler->getForm());

        $anotherFormMock = $this
            ->getMockBuilder('Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->handler->setForm($anotherFormMock);

        $this->assertSame($anotherFormMock, $this->handler->getForm());
    }

    public function testSetAndGetFormFactory()
    {
        $this->assertNull($this->handler->getFormType());

        $factoryMock = $this
            ->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->handler->setFormFactory($factoryMock);

        $this->assertSame($factoryMock, $this->handler->getFormFactory());

        $anotherFactoryMock = $this
            ->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->handler->setFormFactory($anotherFactoryMock);

        $this->assertSame($anotherFactoryMock, $this->handler->getFormFactory());
    }

    public function testSetAndGetFormType()
    {
        $this->assertNull($this->handler->getFormType());

        $type = new FormType();
        $this->handler->setFormType($type);

        $this->assertSame($type, $this->handler->getFormType());

        $anotherType = new FormType();
        $this->handler->setFormType($anotherType);

        $this->assertSame($anotherType, $this->handler->getFormType());
    }

    public function testGetFormIfTypeSet()
    {
        $factoryMock = $this
            ->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $factoryMock
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue($this->formMock))
        ;

        $type = new FormType();

        $handler = new BaseHandler();

        $this->assertNull($handler->getForm());

        $handler->setFormType($type);
        $handler->setFormFactory($factoryMock);

        $this->assertSame($this->formMock, $handler->getForm());

        $anotherFormMock = $this
            ->getMockBuilder('Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->assertSame($this->formMock, $handler->getForm());

        $factoryMock
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue($anotherFormMock))
        ;

        $this->assertSame($this->formMock, $handler->getForm());

        $handler->setForm($anotherFormMock);

        $this->assertSame($anotherFormMock, $handler->getForm());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetFormIfTypeSetNoFactory()
    {
        $type = new FormType();
        $handler = new BaseHandler($type);
        $handler->getForm();
    }
}
