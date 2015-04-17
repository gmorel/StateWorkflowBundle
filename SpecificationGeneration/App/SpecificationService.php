<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\App;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command\RenderWorkflowSpecificationFromWorkflowServiceCommand;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Exception\WorkflowServiceNotFoundException;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\SpecificationRepresentationGeneratorInterface;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\SpecificationWriterInterface;
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

    /** @var SpecificationWriterInterface */
    private $specificationWriter;

    /**
     * @param WorkflowContainer                             $workflowContainer
     * @param SpecificationRepresentationGeneratorInterface $specificationRepresentationGenerator
     * @param SpecificationWriterInterface                  $specificationWriter
     */
    public function __construct(WorkflowContainer $workflowContainer, SpecificationRepresentationGeneratorInterface $specificationRepresentationGenerator, SpecificationWriterInterface $specificationWriter)
    {
        $this->workflowContainer = $workflowContainer;
        $this->specificationRepresentationGenerator = $specificationRepresentationGenerator;
        $this->specificationWriter = $specificationWriter;
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

        $this->specificationWriter->write(
            $htmlSpecificationRepresentation,
            $command->getOutputFileName()
        );
    }

    /**
     * Get all available StateWorkflow service
     *
     * @return string[]
     */
    public function getAvailableWorkflowIds()
    {
        $availableWorkflows = $this->workflowContainer->all();

        $availableWorkflowsIds = array();
        foreach ($availableWorkflows as $availableWorkflow) {
            $availableWorkflowsIds[] = $availableWorkflow->getServiceId();
        }

        return $availableWorkflowsIds;
    }
}
