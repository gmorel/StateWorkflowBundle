<?php
/**
 * Created by PhpStorm.
 * Date: 4/1/14
 * Time: 11:01 AM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\State;

use Acme\DemoBundle\State\Exception\NotImplementedException;
use Acme\DemoBundle\State\Exception\UnsupportedStateActionException;
use Acme\DemoBundle\State\HasStateInterface;
use Acme\DemoBundle\State\Implementation\StateIncomplete;

/**
 * Class AbstractState
 * Helper : set all method as Unsupported Exception
 * By default a State has no transition
 *
 * @see State Design Pattern
 */
class AbstractState implements StateInterface
{
    /** @var StateManager */
    protected $itemContext = null;

    /**
     * {@inheritdoc}
     */
    public function setContext(StateManager $context)
    {
        $this->itemContext = $context;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore Abstract helper
     */
    public function getKey()
    {
        throw new NotImplementedException('Abstract to implement');
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore Abstract helper
     */
    public function getName()
    {
        throw new NotImplementedException('Abstract to implement');
    }

    /**
     * {@inheritdoc}
     */
    public function setAsIncomplete(HasStateInterface $item)
    {
        throw $this->buildUnsupportedException('setAsIncomplete()', $item);
    }

    /**
     * {@inheritdoc}
     */
    public function create(HasStateInterface $item)
    {
        throw $this->buildUnsupportedException('create()', $item);
    }

    /**
     * {@inheritdoc}
     */
    public function setAsPaid(HasStateInterface $item)
    {
        throw $this->buildUnsupportedException('setAsPaid()', $item);
    }

    /**
     * {@inheritdoc}
     */
    public function cancel(HasStateInterface $item)
    {
        throw $this->buildUnsupportedException('cancel()', $item);
    }

    /**
     * {@inheritdoc}
     */
    public function setStateHavingNoTransition(HasStateInterface $item, StateInterface $state)
    {
        throw $this->buildUnsupportedException('setStateHavingNoTransition(' . $state->getKey() . ')', $item);
    }

    /**
     * Helper assisting in generating UnsupportedStateActionException
     * @param string            $methodName Unsupported method name
     * @param HasStateInterface $item       Item under the action
     *
     * @return \Acme\DemoBundle\State\Exception\UnsupportedStateActionException
     */
    protected function buildUnsupportedException($methodName, HasStateInterface $item)
    {
        return new UnsupportedStateActionException(
            'The Item ' . get_class($item) . ' workflow does\'t support the "' . $methodName . '" State Action.'
        );
    }

    /**
     * Helper assisting in generating NotImplementedException
     * @param string            $stateKey   Missing state key
     * @param string            $methodName Action
     * @param HasStateInterface $item       Item under the action
     *
     * @return \Acme\DemoBundle\State\Exception\NotImplementedException
     */
    protected function buildStateNotFoundException($stateKey, $methodName, HasStateInterface $item)
    {
        return new NotImplementedException(
            'State id ' . $stateKey . ' not found for Item ' . get_class($item) . ' during ' . $methodName . ' process.'
        );
    }

    /**
     * Helper assisting in checking if State exists
     * @param string            $stateKey   Missing state key
     * @param string            $methodName Action
     * @param HasStateInterface $item       Item under the action
     *
     * @throws \Acme\DemoBundle\State\Exception\NotImplementedException
     * @return StateInterface|null
     */
    protected function isStateExisting($stateKey, $methodName, HasStateInterface $item)
    {
        $return = null;
        $availableStates = $this->itemContext->getAvailableStates();
        if (isset($availableStates[$stateKey])) {
            $return = $availableStates[$stateKey];
        } else {
            throw $this->buildStateNotFoundException($stateKey, $methodName, $item);
        }

        return $return;
    }

}