<?php
namespace Publero\FrameworkBundle\Traits;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
