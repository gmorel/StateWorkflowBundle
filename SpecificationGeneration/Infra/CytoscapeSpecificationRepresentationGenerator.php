<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Infra;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\SpecificationRepresentationGeneratorInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\IntrospectedWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Representation\HtmlSpecificationRepresentation;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Representation\CytoscapeWorkflowRepresentation;


/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class CytoscapeSpecificationRepresentationGenerator implements SpecificationRepresentationGeneratorInterface
{
    const TEMPLATE_FILE_PATH = 'UI/Resource/workflow-template.html';

    /**
     * {@inheritdoc}
     */
    public function createSpecification(StateWorkflow $stateWorkflow)
    {
        $introspectedWorkflow = new IntrospectedWorkflow($stateWorkflow);

        $templateFilePath = realpath(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE_PATH);

        return new HtmlSpecificationRepresentation(
            new CytoscapeWorkflowRepresentation($introspectedWorkflow),
            $templateFilePath
        );
    }
}
