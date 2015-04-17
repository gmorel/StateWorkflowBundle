<?php

namespace Gmorel\StateWorkflowBundle\Demo\KernelBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Register all entity State to our Booking State Workflow
 * @author Guillaume MOREL <github.com/gmorel>
 */
class RegisterBookingStateWorkflowCompilerPass implements CompilerPassInterface
{
    const STATE_WORKFLOW_ID = 'demo.booking_engine.state_workflow';
    const DEFAULT_STATE_KEY = 'incomplete';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->setBookingStateWorkflow($container);
    }

    /**
     * We instantiate our Booking State Workflow with its States
     * @param ContainerBuilder $container
     */
    private function setBookingStateWorkflow(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(self::STATE_WORKFLOW_ID)) {
            throw new InvalidConfigurationException('Cant find demo.booking_engine.state_workflow service');
        }

        $definition = $container->getDefinition(self::STATE_WORKFLOW_ID);

        $bookingStateServices = $container->findTaggedServiceIds('demo.booking_engine.state');

        foreach ($bookingStateServices as $serviceId => $bookingStateService) {
            $definition->addMethodCall('addAvailableState', array(new Reference($serviceId)));
        }

        $this->setBookingStateWorkflowDefaultState($definition);
    }

    /**
     * We need to set our Booking State Workflow default State
     * @param Definition $definition
     */
    private function setBookingStateWorkflowDefaultState(Definition $definition)
    {
        $definition->addMethodCall(
            'setStateAsDefault',
            array(
                self::DEFAULT_STATE_KEY
            )
        );
    }
}
