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
 * Class StateIncomplete
 * Represents an incomplete Item
 * Manage State Transition
 * Only minimum information are stored yet
 *
 * @see State Design Pattern
 */
class StateIncomplete extends AbstractState
{
    /** Stored in database, easily indexable */
    const KEY = 0;

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
    public function create(HasStateInterface $item)
    {
        $state = $this->isStateExisting(StateWaitingPayment::KEY, 'create()', $item);
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


} 