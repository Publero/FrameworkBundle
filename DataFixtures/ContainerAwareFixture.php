<?php
namespace Publero\FrameworkBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Publero\FrameworkBundle\Traits\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

abstract class ContainerAwareFixture extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}