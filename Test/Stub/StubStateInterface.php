<?php

namespace Gmorel\StateWorkflowBundle\Test\Stub;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;


/**
 * Stub
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
interface StubStateInterface extends StateInterface
{
    /**
     * {@inheritdoc}
     */
    public function initialize(HasStateInterface $entity);

    /**
     * To B
     * @param \Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface $entity
     *
     * @return StateB
     */
    public function setToB(HasStateInterface $entity);

    /**
     * To C
     * @param \Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface $entity
     *
     * @return StateC
     */
    public function setToC(HasStateInterface $entity);
}
