<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Representation;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Representation\SpecificationRepresentationInterface;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 * We avoid to use Twig as not every projects are using it.
 * No need to force them to install this dependency.
 */
class HtmlSpecificationRepresentation implements SpecificationRepresentationInterface
{
    const TEMPLATE_VARIABLE_WORKFLOW_NAME = '__WORKFLOW_NAME__';
    const TEMPLATE_VARIABLE_JSONED_WORKFLOW = '__JSON__';

    /** @var string HTML */
    private $renderedHtml;

    public function __construct(CytoscapeWorkflowRepresentation $workflowRepresentation, $htmlTemplatePath)
    {
        $this->guardAgainstHtmlTemplatePathNotExisting($htmlTemplatePath);

        $htmlTemplate = file_get_contents($htmlTemplatePath);

        $htmlTemplate = $this->fillTemplateWithJsonedWorkflow($workflowRepresentation, $htmlTemplate);

        $renderedHtml = $this->fillTemplateWithWorkflowName($workflowRepresentation, $htmlTemplate);

        $this->renderedHtml = $renderedHtml;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderedHtml;
    }

    /**
     * @param $htmlTemplatePath
     */
    private function guardAgainstHtmlTemplatePathNotExisting($htmlTemplatePath)
    {
        if (!file_exists($htmlTemplatePath)) {
            throw new \LogicException(
                sprintf(
                    'Template file "%s" was not found.',
                    $htmlTemplatePath
                )
            );
        }
    }

    /**
     * @param CytoscapeWorkflowRepresentation $workflowRepresentation
     * @param string                          $htmlTemplate
     *
     * @return string HTML
     */
    private function fillTemplateWithJsonedWorkflow(CytoscapeWorkflowRepresentation $workflowRepresentation, $htmlTemplate)
    {
        return str_replace(
            self::TEMPLATE_VARIABLE_JSONED_WORKFLOW,
            $workflowRepresentation->serialize(),
            $htmlTemplate
        );
    }

    /**
     * @param CytoscapeWorkflowRepresentation $workflowRepresentation
     * @param $htmlTemplate
     * @return mixed
     */
    private function fillTemplateWithWorkflowName(CytoscapeWorkflowRepresentation $workflowRepresentation, $htmlTemplate)
    {
        return str_replace(
            self::TEMPLATE_VARIABLE_WORKFLOW_NAME,
            $workflowRepresentation->getWorkflowName(),
            $htmlTemplate
        );
    }
}
