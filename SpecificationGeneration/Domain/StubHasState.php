<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;

/**
 * Stub used during introspection
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class StubHasState implements HasStateInterface
{
    /**
     * {@inheritdoc}
     */
    public function changeState(StateWorkflow $stateContext, StateInterface $newState)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState(StateWorkflow $stateContext)
    {
        return null;
    }

}
