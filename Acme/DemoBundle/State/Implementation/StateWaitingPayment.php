<?php
/**
 * Created by PhpStorm.
 * Date: 4/1/14
 * Time: 11:17 AM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\State\Implementation;

use Acme\DemoBundle\State;
use Acme\DemoBundle\State\AbstractState;
use Acme\DemoBundle\State\HasStateInterface;

/**
 * Class StateWaitingPayment
 * Represents an Item ready to be paid
 * Manage State Transition
 * All information are stored
 *
 * @see State Design Pattern
 */
class StateWaitingPayment extends AbstractState
{
    /** Stored in database, easily indexable */
    const KEY = 10;

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
    public function setAsIncomplete(HasStateInterface $item)
    {
        $state = $this->isStateExisting(StateIncomplete::KEY, 'setAsIncomplete()', $item);
        if ($state) {
            $this->itemContext->changeState($item, $state);

            // Implement necessary relevant transition here
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function setAsPaid(HasStateInterface $item)
    {
        $state = $this->isStateExisting(StatePaid::KEY, 'setAsPaid()', $item);
        if ($state) {
            $this->itemContext->changeState($item, $state);

            // Implement necessary relevant transition here
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function cancel(HasStateInterface $item)
    {
        $state = $this->isStateExisting(StateCancelled::KEY, 'cancel()', $item);
        if ($state) {
            $this->itemContext->changeState($item, $state);

            // Implement necessary relevant transition here
        }

        return $item;
    }

}