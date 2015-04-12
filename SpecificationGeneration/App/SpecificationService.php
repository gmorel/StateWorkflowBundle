<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\App;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command\RenderWorkflowSpecificationFromWorkflowServiceCommand;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Exception\WorkflowServiceNotFoundException;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\SpecificationRepresentationGeneratorInterface;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\WorkflowContainer;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 * SpecificationGeneration Bounded Context entry point
 */
class SpecificationService
{
    /** @var WorkflowContainer */
    private $workflowContainer;

    /** @var SpecificationRepresentationGeneratorInterface */
    private $specificationRepresentationGenerator;

    /**
     * @param WorkflowContainer                             $workflowContainer
     * @param SpecificationRepresentationGeneratorInterface $specificationRepresentationGenerator
     */
    public function __construct(WorkflowContainer $workflowContainer, SpecificationRepresentationGeneratorInterface $specificationRepresentationGenerator)
    {
        $this->workflowContainer = $workflowContainer;
        $this->specificationRepresentationGenerator = $specificationRepresentationGenerator;
    }

    /**
     * Render specification for the given StateWorkflow
     * @api
     * @param RenderWorkflowSpecificationFromWorkflowServiceCommand $command
     *
     * @throws WorkflowServiceNotFoundException
     */
    public function renderSpecification(RenderWorkflowSpecificationFromWorkflowServiceCommand $command)
    {
        $stateWorkflow = $this->workflowContainer->get(
            $command->getWorkFlowServiceId()
        );

        $htmlSpecificationRepresentation = $this->specificationRepresentationGenerator->createSpecification(
            $stateWorkflow
        );

        file_put_contents(
            $command->getOutputFileName(),
            $htmlSpecificationRepresentation->render()
        );
    }
}
