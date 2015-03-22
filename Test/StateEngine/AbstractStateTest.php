<?php

namespace Gmorel\StateWorkflowBundle\Test\StateEngine;

use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\Test\Stub\Booking;
use Gmorel\StateWorkflowBundle\Test\Stub\StateA;
use Gmorel\StateWorkflowBundle\Test\Stub\StateB;
use Gmorel\StateWorkflowBundle\Test\Stub\StateBadlyImplemented;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class AbstractStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     */
    public function test_unsupported_state_transition()
    {
        // Given
        $workflow = new StateWorkflow('Booking Workflow', 'key');
        $workflow->addAvailableState(new StateA());
        $workflow->addAvailableState(new StateB());
        $workflow->setStateAsDefault(StateA::KEY);

        $entity = new Booking($workflow);

        /** @var StateA $sut */
        $sut = $workflow->getStateFromKey(StateA::KEY);


        // When
        $sut->setToC($entity);
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_state_not_implemented()
    {
        // Given
        $workflow = new StateWorkflow('Booking Workflow', 'key');
        $workflow->addAvailableState(new StateA());
        $workflow->addAvailableState(new StateB());
        $workflow->addAvailableState(new StateBadlyImplemented());
        $workflow->setStateAsDefault(StateA::KEY);

        $entity = new Booking($workflow);

        /** @var StateA $sut */
        $sut = $workflow->getStateFromKey(StateBadlyImplemented::KEY);


        // When
        $sut->setToC($entity);
    }

    /**
     * @expectedException \LogicException
     */
    public function test_state_having_no_workflow()
    {
        // Given
        $workflow = new StateWorkflow('Booking Workflow', 'key');
        $entity = new Booking($workflow);
        $stateBadlyImplemented = new StateBadlyImplemented();

        // When
        $stateBadlyImplemented->setToC($entity);
    }
}
