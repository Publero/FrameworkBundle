<?php
namespace Publero\FrameworkBundle\Test\Traits;

use Publero\FrameworkBundle\Tests\Fixtures\Traits\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class ContainerAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testContainerAwareTrait()
    {
        $container = new ContainerBuilder();
        $containerAware = new ContainerAware();
        $containerAware->setContainer($container);

        $this->assertSame($container, $containerAware->getContainer());
    }
}
