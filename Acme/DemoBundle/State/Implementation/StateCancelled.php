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
use Acme\DemoBundle\State\StateInterface;

/**
 * Class StateCancelled
 * Represents a cancelled Item
 * Manage State Transition
 *
 * @see State Design Pattern
 */
class StateCancelled extends AbstractState
{
    /** Stored in database, easily indexable */
    const KEY = -1;

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
    public function setStateHavingNoTransition(HasStateInterface $item, StateInterface $state)
    {
        $state = $this->isStateExisting($state->getKey(), 'setStateHavingNoTransition(' . $state->getKey() . ')', $item);
        if ($state && $state->getKey() == StateToDelete::KEY) {
            $this->itemContext->changeState($item, $state);

            // Implement necessary relevant transition here
        } else {
            throw $this->buildUnsupportedException('setStateHavingNoTransition(' . $state->getKey() . ')', $item);
        }

        return $item;
    }


} 