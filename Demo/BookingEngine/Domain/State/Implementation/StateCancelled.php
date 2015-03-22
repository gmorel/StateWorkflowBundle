<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\AbstractBookingState;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;

/**
 * Represents a cancelled Entity
 * Manage State Transition
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateCancelled extends AbstractBookingState
{
    /** Stored in database, easily indexable */
    const KEY = 'cancelled';

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
        return 'Annulé';
    }

    /**
     * {@inheritdoc}
     */
    public function setBookingToBeDeleted(HasStateInterface $booking)
    {
        $newState = $this->getStateFromStateId(StateToDelete::KEY, __METHOD__, $booking);
        if ($newState) {
            $booking->changeState($this->getStateWorkflow(), $newState);

            // Implement necessary relevant transition here
        }

        return $newState;
    }
}
