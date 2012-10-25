<?php
namespace Publero\FrameworkBundle\DependencyInjection;

use Publero\FrameworkBundle\DependencyInjection\Compiler\AnnotationReaderReplacePass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class PubleroFrameworkExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
