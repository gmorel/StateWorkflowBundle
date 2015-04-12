<?php

namespace Gmorel\StateWorkflowBundle\Test\StateEngine;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\Entity\Booking;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateIncomplete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StatePaid;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateWorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function test_states_available_workflow()
    {
        // Given
        $stateIncomplete = new StateIncomplete();
        $statePaid = new StatePaid();
        $stateCancelled = new StateCancelled();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($statePaid);
        $stateWorkflow->addAvailableState($stateCancelled);

        $stateWorkflow->setStateAsDefault($stateIncomplete->getKey());

        // Initialize entity state to incomplete
        $entity = new Booking($stateWorkflow, 200);
        $currentState = $entity->getState($stateWorkflow);
        $this->assertEquals($stateIncomplete->getKey(), $currentState->getKey());

        // Set incomplete entity as paid
        $currentState->setBookingAsPaid($entity);
        $currentState = $entity->getState($stateWorkflow);
        $this->assertEquals($statePaid->getKey(), $currentState->getKey());
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     */
    public function test_states_unavailable_workflow()
    {
        // Given
        $stateIncomplete = new StateIncomplete();
        $statePaid = new StatePaid();
        $stateCancelled = new StateCancelled();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($statePaid);
        $stateWorkflow->addAvailableState($stateCancelled);

        $stateWorkflow->setStateAsDefault($stateIncomplete->getKey());

        $entity = new Booking($stateWorkflow, 200);
        $currentState = $entity->getState($stateWorkflow);

        // When
        // The workflow prevents incomplete to cancelled transition
        $currentState->cancelBooking($entity);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_duplicated_states()
    {
        // Given
        $stateIncomplete = new StateIncomplete();
        $statePaid = new StatePaid();
        $duplicated = new StateIncomplete();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($statePaid);

        // When
        $stateWorkflow->addAvailableState($duplicated);
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_illegal_default_state()
    {
        // Given
        $stateIncomplete = new StateIncomplete();
        $statePaid = new StatePaid();
        $stateCancelled = new StateCancelled();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateCancelled);
        $stateWorkflow->addAvailableState($statePaid);

        // When
        $stateWorkflow->setStateAsDefault($stateIncomplete->getKey());
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_default_state_not_set()
    {
        // Given
        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');

        // When
        new Booking($stateWorkflow, 200);
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_unknown_state()
    {
        // Given
        $stateIncomplete = new StateIncomplete();
        $statePaid = new StatePaid();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($statePaid);

        // When
        $stateWorkflow->getStateFromKey('unknown');
    }
}
