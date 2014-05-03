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

/**
 * Class StateToDelete
 * Represents a cancelled Item
 * Manage State Transition
 *
 * @see State Design Pattern
 */
class StateToDelete extends AbstractState
{
    /** Stored in database, easily indexable */
    const KEY = -2;

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
        return 'A supprimer';
    }


} 