<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\AbstractBookingState;

/**
 * Represents a cancelled Entity
 * Manage State Transition
 *
 * @see State Design Pattern
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateToDelete extends AbstractBookingState
{
    /** Stored in database, easily indexable */
    const KEY = 'to_delete';

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'to_delete';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        // @todo I18n
        return 'A supprimer';
    }
}
