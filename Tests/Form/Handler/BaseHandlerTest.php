<?php
namespace Publero\FrameworkBundle\Tests\Form\Handler;

use Publero\FrameworkBundle\Form\Handler\BaseHandler;
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
     * @var BaseHnadler
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
}
