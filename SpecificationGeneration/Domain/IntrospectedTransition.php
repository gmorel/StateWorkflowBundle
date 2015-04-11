<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class IntrospectedTransition
{
    /** @var string */
    private $name;

    /** @var IntrospectedState */
    private $fromIntrospectedState;

    /** @var IntrospectedState */
    private $toIntrospectedState;

    /**
     * @param string            $transitionName
     * @param IntrospectedState $fromIntrospectedState
     * @param IntrospectedState $toIntrospectedState
     */
    public function __construct($transitionName, IntrospectedState $fromIntrospectedState, IntrospectedState $toIntrospectedState)
    {
        $this->guardAgainstEmptyName($transitionName, $fromIntrospectedState, $toIntrospectedState);

        $this->name = $transitionName;
        $this->fromIntrospectedState = $fromIntrospectedState;
        $this->toIntrospectedState = $toIntrospectedState;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @param $name
     * @param IntrospectedState $fromIntrospectedState
     * @param IntrospectedState $toIntrospectedState
     */
    private function guardAgainstEmptyName($name, IntrospectedState $fromIntrospectedState, IntrospectedState $toIntrospectedState)
    {
        if (empty($name)) {
            throw new \LogicException(
                sprintf(
                    'IntrospectedTransition from %s to %s must have a name.',
                    $fromIntrospectedState->getKey(),
                    $toIntrospectedState->getKey()
                )
            );
        }
    }
}
