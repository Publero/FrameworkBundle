<?php
namespace Publero\FrameworkBundle\Tests\Fixtures\Traits;

use Publero\FrameworkBundle\Traits\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class ContainerAware implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
