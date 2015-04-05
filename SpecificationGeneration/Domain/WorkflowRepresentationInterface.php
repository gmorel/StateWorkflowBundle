<?php

namespace SpecificationGeneration\Domain;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
interface WorkflowRepresentationInterface
{
    /**
     * @param IntrospectedWorkflow $instrospectedWorkflow
     *
     * @return string
     */
    public function serialize(IntrospectedWorkflow $instrospectedWorkflow);
}
