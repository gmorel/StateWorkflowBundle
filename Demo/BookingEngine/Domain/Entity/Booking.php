<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\Entity;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\BookingStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\HasStateInterface;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\StateEngine\StateInterface;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Infra\DoctrineEntity\Booking as BookingDoctrineEntity;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class Booking extends BookingDoctrineEntity implements HasStateInterface
{
    public function __construct(StateWorkflow $stateWorkflow, $priceTotal)
    {
        $stateWorkflow->getDefaultState()->initialize($this);

        $this->setPriceTotal($priceTotal);
    }


    /**
     * {@inheritdoc}
     */
    public function setPriceTotal($priceTotal)
    {
        if ($priceTotal < 0) {
            throw new \DomainException(
                sprintf(
                    'Booking total price must be positive. Received %s.',
                    $priceTotal
                )
            );
        }
        $this->priceTotal = floatval($priceTotal);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function changeState(StateWorkflow $stateWorkflow, StateInterface $newState)
    {
        $stateWorkflow->guardExistingState($newState->getKey());
        $this->setStateKey($newState->getKey());

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return BookingStateInterface
     */
    public function getState(StateWorkflow $stateWorkflow)
    {
        return $stateWorkflow->getStateFromKey($this->stateKey);
    }
}
