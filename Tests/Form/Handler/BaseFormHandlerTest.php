<?php
namespace Publero\FrameworkBundle\Tests\Form\Handler;

use Publero\FrameworkBundle\Form\Handler\BaseFormHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

class BaseFormHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface
     */
    private $formMock = null;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var BaseFormHandler
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
        $this->handler = $this->getMock('Publero\FrameworkBundle\Form\Handler\BaseFormHandler', ['onValid']);
    }

    public function testHandleRequest()
    {
        $this->handler->setForm($this->formMock);
        $this->formMock
            ->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(true))
        ;
        $this->formMock
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'))
        ;
        $this->handler
            ->expects($this->once())
            ->method('onValid')
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->handler->handleRequest($this->request));
    }

    public function testHandleRequestFormInvalid()
    {
        $this->handler->setForm($this->formMock);
        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false))
        ;

        $this->assertFalse($this->handler->handleRequest($this->request));
    }

    public function testHandleRequestRequestNotHandled()
    {
        $this->handler->setForm($this->formMock);

        $this->assertFalse($this->handler->handleRequest($this->request));
    }

    public function testGetForm()
    {
        $this->assertNull($this->handler->getForm());

        $this->handler->setForm($this->formMock);

        $this->assertSame($this->formMock, $this->handler->getForm());
    }

    public function testGetFormFromType()
    {
        $factoryMock = $this
            ->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->handler->setFormFactory($factoryMock);

        $type = new FormType();
        $this->handler->setFormType($type);

        $factoryMock
            ->expects($this->once())
            ->method('create')
            ->with($type)
            ->will($this->returnValue($this->formMock))
        ;

        $this->assertSame($this->formMock, $this->handler->getForm());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetFormIfTypeSetNoFactory()
    {
        $type = new FormType();
        $this->handler->setFormType($type);

        $this->handler->getForm();
    }
}
