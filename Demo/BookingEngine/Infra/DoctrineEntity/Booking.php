<?php

namespace Gmorel\StateWorkflowBundle\Demo\BookingEngine\Infra\DoctrineEntity;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class Booking
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $stateKey;

    /** @var float */
    protected $priceTotal;

    /** @var \DateTime */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }

    /**
     * @param float $priceTotal
     *
     * @return $this
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = floatval($priceTotal);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string $stateKey
     *
     * @return $this
     */
    public function setStateKey($stateKey)
    {
        $this->stateKey = $stateKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getStateKey()
    {
        return $this->stateKey;
    }
}
