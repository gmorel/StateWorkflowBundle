<?php

namespace Gmorel\Test\StateWorkflowBundle\StateEngine;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\Entity\Booking;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateToDelete;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;

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
        $workflow->addAvailableState(new StateCancelled);
        $workflow->addAvailableState(new StateToDelete());
        $workflow->setStateAsDefault(StateCancelled::KEY);

        $entity = new Booking($workflow, 200);

        /** @var StateCancelled $sut */
        $sut = $workflow->getStateFromKey(StateCancelled::KEY);


        // When
        $sut->setBookingToBeDeleted($entity);
    }
}
