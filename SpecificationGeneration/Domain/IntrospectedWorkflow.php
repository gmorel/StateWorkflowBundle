<?php

namespace SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\StateEngine\Exception\EmptyWorkflow;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class IntrospectedWorkflow
{
    /** @var IntrospectedState[] */
    private $introspectedStates = array();

    /** @var IntrospectedTransition[] */
    private $introspectedTransitions = array();

    /**
     * @param \Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow $stateWorkflow
     */
    public function __construct(StateWorkflow $stateWorkflow)
    {
        $availableStates = $stateWorkflow->getAvailableStates();

        if (!empty($availableStates)) {
            throw new EmptyWorkflow(
                sprintf(
                    'Workflow "%s" has no State defined.',
                    $stateWorkflow->getName()
                )
            );
        }

        $this->createIntrospectedStates($availableStates);

        $this->createIntrospectedTransitions($availableStates);
    }

    /**
     * @return IntrospectedState[]
     */
    public function getIntrospectedStates()
    {
        return $this->introspectedStates;
    }

    /**
     * @return IntrospectedTransition[]
     */
    public function getIntrospectedTransitions()
    {
        return $this->introspectedTransitions;
    }

    /**
     * @param string         $methodName
     * @param StateInterface $availableState
     *
     * @return IntrospectedTransition
     */
    private function createIntrospectedTransition($methodName, StateInterface $fromState)
    {
        $toState = $this->getToState($fromState, $methodName);

        return new IntrospectedTransition(
            $this->introspectedStates[$fromState->getKey()],
            $this->introspectedStates[$toState->getKey()]
        );
    }

    /**
     * @param StateInterface $state
     *
     * @return IntrospectedState
     */
    private function createIntrospectedState(StateInterface $state)
    {
        return new IntrospectedState(
            $state->getKey(),
            $state->getName()
        );
    }

    /**
     * @param StateInterface $state
     *
     * @return string[]
     */
    private function extractAvailableStateMethodNames(StateInterface $state)
    {
        $methodNames = array();
        $reflection = new \ReflectionClass(get_class($state));

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method['class'] === $reflection->getName()) {
                $methodNames[] = $method['name'];
            }
        }

        return $methodNames;
    }

    /**
     * @param StateInterface[] $availableStates
     */
    private function createIntrospectedStates(array $availableStates)
    {
        foreach ($availableStates as $availableState) {
            $this->introspectedStates[$availableState->getKey()] = $this->createIntrospectedState($availableState);
        }
    }

    /**
     * @param StateInterface[] $availableStates
     */
    private function createIntrospectedTransitions(array $availableStates)
    {
        // Since all States are implementing the same Domain State Interface
        // We only need to test the first State
        $methodNames = $this->extractAvailableStateMethodNames(reset($availableStates));

        foreach ($methodNames as $methodName) {
            foreach ($availableStates as $availableState) {
                try {
                    $this->introspectedTransitions[$methodName] = $this->createIntrospectedTransition(
                        $methodName, $availableState
                    );
                } catch (UnsupportedStateTransitionException $e) {
                    // Do nothing
                }
            }
        }
    }

    /**
     * @param StateInterface $fromState
     * @param string         $methodName
     *
     * @return StateInterface
     */
    private function getToState(StateInterface $fromState, $methodName)
    {
        $toState = $fromState->{$methodName};

        return $toState;
    }
}
