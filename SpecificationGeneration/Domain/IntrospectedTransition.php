<?php


namespace SpecificationGeneration\Domain;


/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class IntrospectedTransition
{
    /** @var IntrospectedState */
    private $fromIntrospectedState;

    /** @var IntrospectedState */
    private $toIntrospectedState;

    public function __construct(IntrospectedState $fromIntrospectedState, IntrospectedState $toIntrospectedState)
    {
        $this->fromIntrospectedState = $fromIntrospectedState;
        $this->toIntrospectedState = $toIntrospectedState;
    }

    /**
     * @return IntrospectedState
     */
    public function getFromIntrospectedState()
    {
        return $this->fromIntrospectedState;
    }

    /**
     * @return IntrospectedState
     */
    public function getToIntrospectedState()
    {
        return $this->toIntrospectedState;
    }
}
