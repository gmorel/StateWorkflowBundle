<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\AbstractBookingState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Represents an Entity ready to be paid
 * Manage State Transition
 * All information are stored
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateWaitingPayment extends AbstractBookingState
{
    /** Stored in database, easily indexable */
    const KEY = 'waiting_for_payment';

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
        return 'En attente de paiement';
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

    /**
     * {@inheritdoc}
     */
    public function cancelBooking(HasStateInterface $booking)
    {
        $newState = $this->getStateFromStateId(StateCancelled::KEY, __METHOD__, $booking);
        if ($newState) {
            $booking->changeState($this->getStateWorkflow(), $newState);

            // Implement necessary relevant transition here
        }

        return $newState;
    }
}
