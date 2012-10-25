<?php
namespace Publero\FrameworkBundle\Tests\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Publero\Component\Test\ContainerAwareTestCase;
use Publero\FrameworkBundle\Annotations\ContainerParameterParsingReader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerParameterParsingReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerParameterParsingReader
     */
    private $reader;

    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        parent::setUp();

        $this->reader = new ContainerParameterParsingReader('Doctrine\Common\Annotations\AnnotationReader');
        $this->container = new ContainerBuilder();
        $this->reader->setContainer($this->container);
    }

    public function testParse()
    {
        $annotation = new Annotation(['value' => '%test_parameter%']);
        $this->container->setParameter('test_parameter', 'test_value');

        $annotation = $this->reader->parse($annotation);

        $this->assertEquals('test_value', $annotation->value);
    }

    public function testParseNull()
    {
        $this->assertNull($this->reader->parse(null));
    }

    public function testParseArray()
    {
        $annotations = [
            new Annotation(['value' => '%test_parameter1%']),
            new Annotation(['value' => '%test_parameter2%'])
        ];
        $this->container->setParameter('test_parameter1', 'test_value1');
        $this->container->setParameter('test_parameter2', 'test_value2');

        $annotations = $this->reader->parse($annotations);

        $this->assertEquals('test_value1', $annotations[0]->value);
        $this->assertEquals('test_value2', $annotations[1]->value);
    }
}
