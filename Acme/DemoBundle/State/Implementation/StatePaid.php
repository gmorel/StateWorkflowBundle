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
 * Class StatePaid
 * Represents a paid Item and paid
 * Manage State Transition
 *
 * @see State Design Pattern
 */
class StatePaid extends AbstractState
{
    /** Stored in database, easily indexable */
    const KEY = 60;

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
        return 'Payé';
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