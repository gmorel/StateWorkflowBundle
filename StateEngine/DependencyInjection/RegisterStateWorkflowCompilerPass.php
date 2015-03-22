<?php

namespace Gmorel\StateWorkflowBundle\StateEngine\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Register all entity State Workflow
 * @author Guillaume MOREL <github.com/gmorel>
 */
class RegisterStateWorkflowCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('state_workflow_bundle.generate_workflow_specifications.command')) {
            throw new InvalidConfigurationException('Cant find state_workflow_bundle.generate_workflow_specifications.command service');
        }

        $definition = $container->getDefinition('state_workflow_bundle.generate_workflow_specifications.command');

        $services = $container->findTaggedServiceIds('state_workflow_bundle.workflow');

        foreach ($services as $id => $attributes) {
            $definition->addMethodCall('addWorkflow', array(new Reference($id)));
        }
    }
}
