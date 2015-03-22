<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State;

use Gmorel\StateWorkflowBundle\StateEngine\AbstractState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Helper : set all method as Unsupported Exception
 * Consequently by default a State has no transition
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
abstract class AbstractBookingState extends AbstractState implements BookingStateInterface
{
    /**
     * {@inheritdoc}
     */
    public function initialize(HasStateInterface $booking)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $booking);
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingAsWaitingForPayment(HasStateInterface $booking)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $booking);
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingAsPaid(HasStateInterface $booking)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $booking);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelBooking(HasStateInterface $booking)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $booking);
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingToBeDeleted(HasStateInterface $booking)
    {
        throw $this->buildUnsupportedTransitionException(__METHOD__, $booking);
    }
}
