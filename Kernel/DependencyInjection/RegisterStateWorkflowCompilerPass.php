<?php

namespace Gmorel\StateWorkflowBundle\Kernel\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Register all State Workflow entity
 * @author Guillaume MOREL <github.com/gmorel>
 */
class RegisterStateWorkflowCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('state_workflow_bundle.workflow.container')) {
            throw new InvalidConfigurationException('Cant find "state_workflow_bundle.workflow.container" service');
        }

        $definition = $container->getDefinition('state_workflow_bundle.workflow.container');

        $services = $container->findTaggedServiceIds('state_workflow_bundle.workflow');

        foreach ($services as $id => $attributes) {
            $definition->addMethodCall('addWorkflow', array(new Reference($id)));
        }
    }
}
