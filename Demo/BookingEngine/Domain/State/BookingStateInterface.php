<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StatePaid;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateToDelete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateWaitingPayment;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;

/**
 * Represent all your Booking workflow's actions
 * @author Guillaume MOREL <github.com/gmorel>
 */
interface BookingStateInterface extends StateInterface
{
    /**
     * @param HasStateInterface $booking Entity
     *
     * @return StateWaitingPayment New State
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function setBookingAsWaitingForPayment(HasStateInterface $booking);

    /**
     * @param HasStateInterface $booking Entity
     *
     * @return StatePaid New State
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function setBookingAsPaid(HasStateInterface $booking);

    /**
     * @param HasStateInterface $booking Entity
     *
     * @return StateCancelled New State
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function cancelBooking(HasStateInterface $booking);


    /**
     * @param HasStateInterface $booking
     *
     * @return StateToDelete New State
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException
     * @throws \Gmorel\StateWorkflowBundle\StateEngine\Exception\StateNotImplementedException
     */
    public function setBookingToBeDeleted(HasStateInterface $booking);
}
