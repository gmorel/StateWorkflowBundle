<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\AbstractBookingState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Represents an incomplete Entity
 * Manage State Transition
 * Only minimum information are stored yet
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateIncomplete extends AbstractBookingState
{
    /** Stored in database, easily indexable */
    const KEY = 'incomplete';

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
        // @todo I18n
        return 'Incomplet';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(HasStateInterface $booking)
    {
        $booking->changeState($this->getStateWorkflow(), $this);

        // Implement necessary relevant transition here

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingAsWaitingForPayment(HasStateInterface $booking)
    {
        $newState = $this->getStateFromStateId(StateWaitingPayment::KEY, __METHOD__, $booking);
        if ($newState) {
            $booking->changeState($this->getStateWorkflow(), $newState);

            // Implement necessary relevant transition here
        }

        return $newState;
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingAsPaid(HasStateInterface $booking)
    {
        $newState = $this->getStateFromStateId(StatePaid::KEY, __METHOD__, $booking);
        if ($newState) {
            $booking->changeState($this->getStateWorkflow(), $newState);

            // Implement necessary relevant transition here
        }

        return $newState;
    }
}
