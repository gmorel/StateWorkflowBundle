<?php

namespace Gmorel\StateWorkflowBundle\StateEngine;

use Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException;

/**
 * Manage entity states workflow
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateWorkflow
{
    /** @var string */
    private $name;

    /** @var string */
    private $serviceId;

    /** @var StateInterface[] */
    private $availableStates = array();

    /** @var string */
    private $defaultStateKey;

    /**
     * @param string $name
     * @param string $serviceId
     */
    public function __construct($name, $serviceId)
    {
        if (empty($name)) {
            throw new \LogicException('A StateWorkflow has to have a name.');
        }

        if (empty($serviceId)) {
            throw new \LogicException('A StateWorkflow has to have a service id.');
        }

        $this->name = $name;
        $this->serviceId = $serviceId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Add an available state
     * @param StateInterface $state State to add for this Service
     *
     * @see    CompilerPass
     * @throws \InvalidArgumentException when tries to add State having an existing key
     */
    public function addAvailableState(StateInterface $state)
    {
        if (array_key_exists($state->getKey(), $this->availableStates)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Conflict : State key "%s" for the given State "%s" is already used in workflow "%s".',
                    $state->getKey(),
                    get_class($state),
                    $this->name
                )
            );
        }

        $state->setWorkflow($this);
        $this->availableStates[$state->getKey()] = $state;
    }

    /**
     * @return StateInterface[]
     */
    public function getAvailableStates()
    {
        return $this->availableStates;
    }

    /**
     * Set attributed State when Entity is created
     * @param string $defaultStateKey
     *
     * @throws StateNotImplementedException
     */
    public function setStateAsDefault($defaultStateKey)
    {
        if (!array_key_exists($defaultStateKey, $this->availableStates)) {
            throw new StateNotImplementedException(
                sprintf(
                    'State set as default "%s" not found in workflow "%s".',
                    $defaultStateKey,
                    $this->name
                )
            );
        }

        $this->defaultStateKey = $defaultStateKey;
    }

    /**
     * @return StateInterface
     */
    public function getDefaultState()
    {
        return $this->getStateFromKey($this->defaultStateKey);
    }

    /**
     * Get current entity State
     * @param string $stateKey
     *
     * @return StateInterface
     * @throws StateNotImplementedException
     */
    public function getStateFromKey($stateKey)
    {
        $this->guardExistingState($stateKey);

        return $this->availableStates[$stateKey];
    }

    /**
     * @param string $stateKey
     *
     * @throws StateNotImplementedException
     */
    public function guardExistingState($stateKey)
    {
        if (!array_key_exists($stateKey, $this->availableStates)) {

            throw new StateNotImplementedException(
                sprintf(
                    'State key "%s", not found. Currently available States : %s.',
                    $stateKey,
                    implode(', ', array_keys($this->availableStates))
                )
            );
        }
    }
}
