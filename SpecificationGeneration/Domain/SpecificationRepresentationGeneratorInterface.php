<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Representation\HtmlSpecificationRepresentation;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
interface SpecificationRepresentationGeneratorInterface
{
    /**
     * @param StateWorkflow $stateWorkflow
     * @return HtmlSpecificationRepresentation
     */
    public function createSpecification(StateWorkflow $stateWorkflow);
}
