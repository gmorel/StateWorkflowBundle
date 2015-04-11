<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
interface WorkflowRepresentationInterface
{
    /**
     * @return string
     */
    public function serialize();
}
