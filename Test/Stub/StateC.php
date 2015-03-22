<?php

namespace Gmorel\StateWorkflowBundle\Test\Stub;

use Gmorel\StateWorkflowBundle\StateEngine\AbstractState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Stub
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateC extends AbstractState implements StubStateInterface
{
    /** Stored in database, easily indexed */
    const KEY = 'c';

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return self::KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'C';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(HasStateInterface $entity)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $entity);
    }

    /**
     * {@inheritdoc}
     */
    public function setToB(HasStateInterface $entity)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $entity);
    }

    /**
     * {@inheritdoc}
     */
    public function setToC(HasStateInterface $entity)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $entity);
    }
}
