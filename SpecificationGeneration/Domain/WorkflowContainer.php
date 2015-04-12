<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Exception\WorkflowServiceNotFoundException;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class WorkflowContainer
{
    /** @var StateWorkflow[] */
    private $workflows = array();

    /**
     * Used by DIC during compiler pass
     * @param StateWorkflow $stateWorkflow
     */
    public function addWorkflow(StateWorkflow $stateWorkflow)
    {
        $this->workflows[$stateWorkflow->getKey()] = $stateWorkflow;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->workflows[$id])) {
            throw new WorkflowServiceNotFoundException(
                sprintf('Workflow service "%s" not found in Sf2 DIC.', $id)
            );
        }

        $workflow = $this->workflows[$id];

        return $workflow;
    }
}
