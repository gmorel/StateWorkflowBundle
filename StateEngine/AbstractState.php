<?php

namespace Gmorel\StateWorkflowBundle\StateEngine;

use Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException;
use Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException;

/**
 * Helper : set all method as Unsupported Exception
 * Consequently by default a State has no transition
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
abstract class AbstractState
{
    /** @var StateWorkflow */
    private $stateWorkflow;

    /**
     * {@inheritdoc}
     */
    public function setWorkflow(StateWorkflow $stateWorkflow)
    {
        $this->stateWorkflow = $stateWorkflow;

        return $this;
    }

    /**
     * Helper assisting in generating UnsupportedStateTransitionException
     * @param string            $methodName Unsupported method name
     * @param HasStateInterface $entity     Entity under the action
     *
     * @return \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     */
    protected function buildUnsupportedTransitionException($methodName, HasStateInterface $entity)
    {
        return new UnsupportedStateTransitionException(
            sprintf(
                'The entity "%s" does\'t support the "%s" State transition from State "%s" in workflow "%s".',
                get_class($entity),
                $methodName,
                get_called_class(),
                $this->getStateWorkflow()->getName()
            )
        );
    }

    /**
     * Helper assisting in generating StateNotImplementedException
     * @param string            $stateId    Missing state key
     * @param string            $methodName Action
     * @param HasStateInterface $entity     Entity under the action
     *
     * @return \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    protected function buildStateNotFoundException($stateId, $methodName, HasStateInterface $entity)
    {
        return new StateNotImplementedException(
            sprintf(
                'State id "%s" not found for Entity "%s" during "%s" process in workflow "%s".',
                $stateId,
                get_class($entity),
                $methodName,
                $this->getStateWorkflow()->getName()
            )
        );
    }

    /**
     * Helper assisting in checking if State exists
     * @param string            $stateKey   Missing state key
     * @param string            $methodName Action
     * @param HasStateInterface $entity     Entity under the action
     *
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     * @return StateInterface
     */
    protected function getStateFromStateId($stateKey, $methodName, HasStateInterface $entity)
    {
        try {
            $state = $this->getStateWorkflow()->getStateFromKey($stateKey);
        } catch (StateNotImplementedException $e) {
            throw $this->buildStateNotFoundException($stateKey, $methodName, $entity);
        }

        return $state;
    }

    /**
     * @return StateWorkflow
     * @throws \LogicException Whenever StateWorkflow is not set
     */
    protected function getStateWorkflow()
    {
        if (null === $this->stateWorkflow) {
            throw new \LogicException(
                'StateWorkflow dependency not found. You might have forgotten to call `$state->setWorkflow($stateWorkflow);`.'
            );
        }

        return $this->stateWorkflow;
    }
}
