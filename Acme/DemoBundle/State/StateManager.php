<?php
/**
 * Created by PhpStorm.
 * Date: 4/1/14
 * Time: 10:49 AM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\State;
use Acme\DemoBundle\State\Exception\NotImplementedException;


/**
 * Class StateManager
 * Manage item states
 *
 * @see State Design Pattern
 */
class StateManager
{

    /**
     * Available States
     * @var array
     */
    protected $availableStates = array();

    /**
     * Default state index in availableStates
     * @var int
     */
    protected $defaultState = 0;

    /**
     * Constructor
     * @param int $defaultState Default state index in availableStates
     */
    public function __construct($defaultState = 0)
    {
        $this->defaultState = $defaultState;
    }

    /**
     * Init Item with default state
     * @param HasStateInterface $item Item to modify
     *
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return HasStateInterface
     */
    public function initState(HasStateInterface $item)
    {
        if (isset($this->availableStates[$this->defaultState])) {
            /** @var StateInterface $default */
            $default = $this->availableStates[$this->defaultState];
            $item = $this->changeState($item, $default);
        } else {
            throw new NotImplementedException(
                'Default state not found for Item ' . get_class($item) . ')'
            );
        }

        return $item;
    }

    /**
     * Change given Item State
     * DON'T Persist
     * @param HasStateInterface $item Item Document
     * @param StateInterface    $state New State
     *
     * @api
     * @return StateInterface
     */
    public function changeState(HasStateInterface $item, StateInterface $state)
    {
        $item->setStatus($state->getKey());

        return $item;
    }

    /**
     * Get current Item State
     * @param HasStateInterface $item Item Document
     *
     * @return StateInterface|null
     */
    public function getCurrentState(HasStateInterface $item)
    {
        $state = null;
        if (isset($this->availableStates[$item->getStatus()])) {
            $state = $this->availableStates[$item->getStatus()];
        }

        return $state;
    }

    /**
     * Add an available state
     * @param StateInterface $state State to add for this Service
     *
     * @see    Service
     * @throws \InvalidArgumentException when tries to add State having an existing key
     * @return $this
     */
    public function addAvailableState(StateInterface $state)
    {
        if (isset($this->availableStates[$state->getKey()])) {
            throw new \InvalidArgumentException('Conflict : State key ' . $state->getKey() . ' for the given State ' . get_class($state) . ' is already used');
        }
        $state->setContext($this);
        $this->availableStates[$state->getKey()] = $state;

        return $this;
    }

    /**
     * Return Service available States
     *
     * @return StateInterface[]
     */
    public function getAvailableStates()
    {
        return $this->availableStates;
    }

}