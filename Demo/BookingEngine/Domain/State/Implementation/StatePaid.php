<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\AbstractBookingState;

/**
 * Represents a paid Entity and paid
 * Manage State Transition
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StatePaid extends AbstractBookingState
{
    /** Stored in database, easily indexable */
    const KEY = 'paid';

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'paid';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        // @todo I18n
        return 'Payé';
    }
}
