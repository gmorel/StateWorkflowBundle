<?php
/**
 * Created by PhpStorm.
 * Date: 4/1/14
 * Time: 10:51 AM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\State;


/**
 * Interface StateInterface
 * Gather all actions that can modify an Item State
 *
 * @see     State Design Pattern
 */
interface StateInterface
{

    /**
     * Set State Item context which will perform actions
     *
     * @param StateManager $context Item context managing States
     *
     * @return $this
     */
    public function setContext(StateManager $context);

    /**
     * Get state key stored in database (easily indexable)
     *
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return string
     */
    public function getKey();

    /**
     * Get state name human readable
     *
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return string
     */
    public function getName();

    /**
     * Set an Item as incomplete
     * @param HasStateInterface $item Item Document
     *
     * @throws \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return HasStateInterface
     */
    public function setAsIncomplete(HasStateInterface $item);

    /**
     * Create an Item
     * @param HasStateInterface $item Item Document
     *
     * @throws \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return HasStateInterface
     */
    public function create(HasStateInterface $item);

    /**
     * Set an Item as Paid
     * @param HasStateInterface $item Item Document
     *
     * @throws \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return HasStateInterface
     */
    public function setAsPaid(HasStateInterface $item);

    /**
     * Cancel an Item
     * @param HasStateInterface $item Item Document
     *
     * @throws \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return HasStateInterface
     */
    public function cancel(HasStateInterface $item);

    /**
     * Set an Item to a State having no transition
     * Useful when you don't want to implement all the logic of in old States class
     * @param HasStateInterface      $item Item Document
     * @param StateInterface $state New State
     *
     * @throws \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     * @return StateInterface|null
     */
    public function setStateHavingNoTransition(HasStateInterface $item, StateInterface $state);
} 