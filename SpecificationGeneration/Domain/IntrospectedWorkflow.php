<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\StateEngine\Exception\EmptyWorkflowException;
use Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException;
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

        if (empty($availableStates)) {
            throw new EmptyWorkflowException(
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
     * @param StateInterface $fromState
     *
     * @return IntrospectedTransition
     * @throws StateNotImplementedException
     */
    private function createIntrospectedTransition($methodName, StateInterface $fromState)
    {
        $toState = $this->getToState($fromState, $methodName);

        return new IntrospectedTransition(
            $methodName,
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

        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($publicMethods as $method) {
            if ($this->isTransitionMethod($method->getName())
                && $method->getDeclaringClass()->getName() === $reflection->getName()) {
                $methodNames[] = $method->getName();
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
        $methodNames = array();
        foreach ($availableStates as $availableToState) {
            $methodNames = array_unique(array_merge(
                $methodNames, $this->extractAvailableStateMethodNames($availableToState)
            ));
        }

        foreach ($availableStates as $availableToState) {
            foreach ($methodNames as $methodName) {
                try {
                    $transitionName = $methodName . '_from_' . $availableToState->getKey();
                    $this->introspectedTransitions[$transitionName] = $this->createIntrospectedTransition(
                        $methodName, $availableToState
                    );
                } catch (UnsupportedStateTransitionException $e) {
                    // Do nothing
                }
            }
        }

        $this->guessIsIntrospectedStateRootOrLeaf();
    }

    /**
     * @param StateInterface $fromState
     * @param string         $methodName
     *
     * @return StateInterface
     * @throws StateNotImplementedException
     */
    private function getToState(StateInterface $fromState, $methodName)
    {
        if (!method_exists($fromState, $methodName)) {
            throw new UnsupportedStateTransitionException(
                sprintf('State %s has no method %s.', $fromState->getKey(), $methodName)
            );
        }

        return call_user_func(array($fromState, $methodName), new StubHasState());
    }

    /**
     * @param string $methodName
     *
     * @return bool
     */
    private function isTransitionMethod($methodName)
    {
        return !in_array($methodName, array('getKey', 'getName', 'setWorkflow', 'initialize'));
    }

    private function guessIsIntrospectedStateRootOrLeaf()
    {
        foreach ($this->introspectedStates as $introspectedState) {
            $isRoot = true;
            $isLeaf = true;
            foreach ($this->introspectedTransitions as $introspectedTransition) {
                if ($introspectedTransition->getFromIntrospectedState()->getKey() === $introspectedState->getKey()) {
                    $isLeaf = false;
                }
                if ($introspectedTransition->getToIntrospectedState()->getKey() === $introspectedState->getKey()) {
                    $isRoot = false;
                }
            }

            if ($isRoot) {
                $introspectedState->setIsRoot();
            }

            if ($isLeaf) {
                $introspectedState->setIsLeaf();
            }
        }
    }
}
