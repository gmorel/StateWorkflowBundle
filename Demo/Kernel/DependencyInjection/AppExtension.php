<?php

namespace Gmorel\StateWorkflowBundle\Demo\Kernel\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('demo_services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'demo_kernel';
    }
}
