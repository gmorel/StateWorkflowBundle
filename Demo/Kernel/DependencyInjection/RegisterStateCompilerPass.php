<?php

namespace Gmorel\StateWorkflowBundle\Demo\Kernel\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Register all entity State
 * @author Guillaume MOREL <github.com/gmorel>
 */
class RegisterStateCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('demo.booking_engine.state_workflow')) {
            throw new InvalidConfigurationException('Cant find demo.booking_engine.state_workflow service');
        }

        $definition = $container->getDefinition('demo.booking_engine.state_workflow');

        $services = $container->findTaggedServiceIds('demo.booking_engine.state');

        foreach ($services as $id => $attributes) {
            $definition->addMethodCall('addAvailableState', array(new Reference($id)));
        }
    }
}
