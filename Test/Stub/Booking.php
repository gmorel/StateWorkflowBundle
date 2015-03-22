<?php

namespace Gmorel\StateWorkflowBundle\Test\Stub;

use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;

/**
 * Entity example
 * @author Guillaume MOREL <github.com/gmorel>
 */
class Booking implements HasStateInterface
{
    /** @var string */
    protected $stateKey;

    public function __construct(StateWorkflow $stateWorkflow)
    {
        $stateWorkflow->getDefaultState()->initialize($this);
    }

    /**
     * @param string $stateKey
     *
     * @return $this
     */
    public function setStateKey($stateKey)
    {
        $this->stateKey = $stateKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getStateKey()
    {
        return $this->stateKey;
    }

    /**
     * {@inheritdoc}
     */
    public function changeState(StateWorkflow $stateWorkflow, StateInterface $newState)
    {
        $stateWorkflow->guardExistingState($newState->getKey());
        $this->setStateKey($newState->getKey());

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return StateInterface
     */
    public function getState(StateWorkflow $stateWorkflow)
    {
        return $stateWorkflow->getStateFromKey($this->stateKey);
    }
}
