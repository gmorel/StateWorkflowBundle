<?php

namespace Gmorel\StateWorkflowBundle\StateEngine;

/**
 * Allow an entity to have a State
 * @author Guillaume MOREL <github.com/gmorel>
 */
interface HasStateInterface
{
    /**
     * Set entity new state
     * @param StateWorkflow   $stateContext
     * @param StateInterface $newState
     *
     * @return $this
     */
    public function changeState(StateWorkflow $stateContext, StateInterface $newState);

    /**
     * Get current entity state
     * @param StateWorkflow $stateContext
     *
     * @return StateInterface
     */
    public function getState(StateWorkflow $stateContext);
}
