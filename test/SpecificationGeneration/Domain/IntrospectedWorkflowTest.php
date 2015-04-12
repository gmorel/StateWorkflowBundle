<?php

namespace Test\StateWorkflowBundle\SpecificationGeneration\Domain;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateIncomplete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StatePaid;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateToDelete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateWaitingPayment;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\IntrospectedState;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\IntrospectedTransition;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\IntrospectedWorkflow as SUT;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class IntrospectedWorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_introspect_workflow_states()
    {
        // Given
        $stateWorkflow = $this->createValidStateWorkflow();
        $expected = $this->createExpectedStates();

        $expected['incomplete']->setIsRoot();
        $expected['to_delete']->setIsLeaf();
        $expected['paid']->setIsLeaf();

        // When
        $introspectedWorkflow = new SUT($stateWorkflow);
        $actual = $introspectedWorkflow->getIntrospectedStates();

        // Then
        $this->assertEquals($expected, $actual, 'State are not well introspected anymore.');
    }

    public function test_it_should_introspect_workflow_transitions()
    {
        // Given
        $stateWorkflow = $this->createValidStateWorkflow();

        $expectedStates = $this->createExpectedStates();

        $expectedStates['incomplete']->setIsRoot();
        $expectedStates['to_delete']->setIsLeaf();
        $expectedStates['paid']->setIsLeaf();

        $expectedTransitions = array(
            'setBookingAsWaitingForPayment_from_incomplete' => new IntrospectedTransition(
                'setBookingAsWaitingForPayment',
                $expectedStates['incomplete'],
                $expectedStates['waiting_for_payment']
            ),
            'setBookingAsPaid_from_incomplete' => new IntrospectedTransition(
                'setBookingAsPaid',
                $expectedStates['incomplete'],
                $expectedStates['paid']
            ),
            'setBookingAsPaid_from_waiting_for_payment' => new IntrospectedTransition(
                'setBookingAsPaid',
                $expectedStates['waiting_for_payment'],
                $expectedStates['paid']
            ),
            'cancelBooking_from_waiting_for_payment' => new IntrospectedTransition(
                'cancelBooking',
                $expectedStates['waiting_for_payment'],
                $expectedStates['cancelled']
            ),
            'setBookingToBeDeleted_from_cancelled' => new IntrospectedTransition(
                'setBookingToBeDeleted',
                $expectedStates['cancelled'],
                $expectedStates['to_delete']
            )
        );

        // When
        $introspectedWorkflow = new SUT($stateWorkflow);
        $actual = $introspectedWorkflow->getIntrospectedTransitions();

        // Then
        $this->assertEquals($expectedTransitions, $actual, 'Transitions are not well introspected anymore.');
    }

    /**
     * @return StateWorkflow
     */
    private function createValidStateWorkflow()
    {
        $stateIncomplete = new StateIncomplete();
        $stateWaitingPayment = new StateWaitingPayment();
        $statePaid = new StatePaid();
        $stateCancelled = new StateCancelled();
        $stateToDelete = new StateToDelete();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($stateWaitingPayment);
        $stateWorkflow->addAvailableState($statePaid);
        $stateWorkflow->addAvailableState($stateCancelled);
        $stateWorkflow->addAvailableState($stateToDelete);

        $stateWorkflow->setStateAsDefault($stateIncomplete->getKey());

        return $stateWorkflow;
    }

    /**
     * @return IntrospectedState[]
     */
    private function createExpectedStates()
    {
        return array(
            'incomplete' => new IntrospectedState('incomplete', 'Incomplet'),
            'waiting_for_payment' => new IntrospectedState('waiting_for_payment', 'En attente de paiement'),
            'paid' => new IntrospectedState('paid', 'Payé'),
            'cancelled' => new IntrospectedState('cancelled', 'Annulé'),
            'to_delete' => new IntrospectedState('to_delete', 'A supprimer')
        );
    }
}
