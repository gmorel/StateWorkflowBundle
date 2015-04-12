<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Representation;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
interface SpecificationRepresentationInterface
{
    /**
     * Render human readable workflow specification page
     *
     * @return string
     */
    public function render();
}
