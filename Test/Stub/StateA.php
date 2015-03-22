<?php

namespace Gmorel\StateWorkflowBundle\Test\Stub;

use Gmorel\StateWorkflowBundle\StateEngine\AbstractState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Stub
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateA extends AbstractState implements StubStateInterface
{
    /** Stored in database, easily indexed */
    const KEY = 'a';

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
        return 'A';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(HasStateInterface $entity)
    {
        $entity->changeState($this->getStateWorkflow(), $this);
    }

    /**
     * {@inheritdoc}
     */
    public function setToB(HasStateInterface $entity)
    {
        $newState = $this->getStateFromStateId(StateB::KEY, __METHOD__, $entity);
        if ($newState) {
            $entity->changeState($this->getStateWorkflow(), $newState);

            // Implement necessary relevant transition here
        }

        return $newState;
    }

    /**
     * {@inheritdoc}
     */
    public function setToC(HasStateInterface $entity)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $entity);
    }
}
