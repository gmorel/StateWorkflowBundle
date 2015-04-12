<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 * @see Command Design Pattern
 * SpecificationGeneration Bounded Context available behaviour
 */
class RenderWorkflowSpecificationFromWorkflowServiceCommand
{
    /** @var string */
    private $workFlowServiceId;

    /** @var string */
    private $outputFileName;

    /**
     * @param string $workFlowServiceId
     * @param string $outputFileName
     */
    public function __construct($workFlowServiceId, $outputFileName)
    {
        $this->workFlowServiceId = $workFlowServiceId;
        $this->outputFileName = $outputFileName;
    }

    /**
     * @return string
     */
    public function getWorkFlowServiceId()
    {
        return $this->workFlowServiceId;
    }

    /**
     * @return string
     */
    public function getOutputFileName()
    {
        return $this->outputFileName;
    }
}
