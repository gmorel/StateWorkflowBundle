<?php

namespace Gmorel\StateWorkflowBundle\StateEngine;

/**
 * Gather all actions that can modify an object implementing HasStateInterface
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
interface StateInterface
{
    /**
     * Set State entity workflow which will perform transitions
     *
     * @param StateWorkflow $stateWorkflow Entity workflow managing States
     *
     * @return $this
     */
    public function setWorkflow(StateWorkflow $stateWorkflow);

    /**
     * Get state key stored in database (easily indexed)
     *
     * @return string
     */
    public function getKey();

    /**
     * Get state name human readable
     *
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     * @return string
     */
    public function getName();

    /**
     * Initialize an Entity
     * @param HasStateInterface $entity
     *
     * @return StateInterface New state
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function initialize(HasStateInterface $entity);
}
