<?php

namespace Gmorel\StateWorkflowBundle\Test\StateEngine;

use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\Test\Stub\Booking;
use Gmorel\StateWorkflowBundle\Test\Stub\StateA;
use Gmorel\StateWorkflowBundle\Test\Stub\StateB;
use Gmorel\StateWorkflowBundle\Test\Stub\StateC;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateWorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function test_states_available_workflow()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();
        $stateC = new StateC();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateA);
        $stateWorkflow->addAvailableState($stateB);
        $stateWorkflow->addAvailableState($stateC);

        $stateWorkflow->setStateAsDefault($stateA->getKey());

        // Initialize entity state to incomplete
        $entity = new Booking($stateWorkflow);

        /** @var StateA $currentState */
        $currentState = $entity->getState($stateWorkflow);
        $this->assertEquals($stateA->getKey(), $currentState->getKey());

        // Set A entity as B
        $currentState->setToB($entity);

        /** @var StateB $currentState */
        $currentState = $entity->getState($stateWorkflow);
        $this->assertEquals($stateB->getKey(), $currentState->getKey());
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     */
    public function test_states_unavailable_workflow()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();
        $stateC = new StateC();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateA);
        $stateWorkflow->addAvailableState($stateB);
        $stateWorkflow->addAvailableState($stateC);

        $stateWorkflow->setStateAsDefault($stateA->getKey());

        $entity = new Booking($stateWorkflow);
        /** @var StateA $currentState */
        $currentState = $entity->getState($stateWorkflow);

        // The workflow prevents A to B transition
        $currentState->setToC($entity);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_duplicated_states()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();
        $duplicated = new StateA();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateA);
        $stateWorkflow->addAvailableState($stateB);

        // When
        $stateWorkflow->addAvailableState($duplicated);
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_illegal_default_state()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();
        $stateC = new StateC();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'service_id');
        $stateWorkflow->addAvailableState($stateC);
        $stateWorkflow->addAvailableState($stateB);

        // When
        $stateWorkflow->setStateAsDefault($stateA->getKey());
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_default_state_not_set()
    {
        // Given
        $stateWorkflow = new StateWorkflow('Booking Workflow', 'service_id');

        // When
        new Booking($stateWorkflow);
    }

    /**
     * @expectedException \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function test_unknown_state()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'service_id');
        $stateWorkflow->addAvailableState($stateA);
        $stateWorkflow->addAvailableState($stateB);

        // When
        $stateWorkflow->getStateFromKey('unknown');
    }

    /**
     * @expectedException \LogicException
     */
    public function test_without_name()
    {
        new StateWorkflow(null, 'service_id');
    }

    /**
     * @expectedException \LogicException
     */
    public function test_without_service_id()
    {
        new StateWorkflow('Booking Workflow', null);
    }

    /**
     *
     */
    public function test_service_id_well_injected()
    {
        // Given
        $expected = 'service_id';
        $workflow = new StateWorkflow('Booking Workflow', $expected);

        // When
        $actual = $workflow->getServiceId();

        // Then
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     */
    public function test_available_states_well_injected()
    {
        // Given
        $stateA = new StateA();
        $stateB = new StateB();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'service_id');
        $stateWorkflow->addAvailableState($stateA);
        $stateWorkflow->addAvailableState($stateB);

        $expected = array(
            StateA::KEY => $stateA,
            StateB::KEY => $stateB
        );

        // When;
        $actual = $stateWorkflow->getAvailableStates();

        // Then
        $this->assertEquals($expected, $actual);
    }
}
