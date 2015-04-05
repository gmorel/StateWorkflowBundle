<?php

namespace SpecificationGeneration\Infra;

use SpecificationGeneration\Domain\IntrospectedState;
use SpecificationGeneration\Domain\IntrospectedTransition;
use SpecificationGeneration\Domain\IntrospectedWorkflow;
use SpecificationGeneration\Domain\WorkflowRepresentationInterface;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class CytoscapeWorkflowRepresentation implements WorkflowRepresentationInterface
{
    const KEY_STATE = 'nodes';
    const KEY_TRANSITION = 'edges';

    const DEFAULT_STATE_WEIGHT = 50;
    const DEFAULT_TRANSITION_STRENGTH = 20;

    const STATE_SHAPE_ROOT = 'triangle';
    const STATE_SHAPE_NORMAL = 'rectangle';
    const STATE_SHAPE_LEAF = 'ellipse';

    /**
     * {@inheritdoc}
     * @return string JSON
     */
    public function serialize(IntrospectedWorkflow $instrospectedWorkflow)
    {
        $colors = $this->generateStatesUniqColor(
            $instrospectedWorkflow->getIntrospectedStates()
        );

        return json_encode(
            array(
                self::KEY_STATE => $this->createStatesRepresentation(
                    $instrospectedWorkflow->getIntrospectedStates(),
                    $colors
                ),
                self::KEY_TRANSITION => $this->createTransitionsRepresentation(
                    $instrospectedWorkflow->getIntrospectedTransitions(),
                    $colors
                )
            )
        );
    }

    /**
     * @param IntrospectedState[] $introspectedStates
     * @param string[]            $colors
     *
     * @return array
     */
    private function createStatesRepresentation(array $introspectedStates, array $colors)
    {
        $jsonableStates = array();
        foreach ($introspectedStates as $introspectedState) {
            $jsonableStates[] = array(
                'data' => array(
                    'id' => $introspectedState->getKey(),
                    'name' => $introspectedState->getName(),
                    'weight' => self::DEFAULT_STATE_WEIGHT,
                    'faveColor' => $colors[$introspectedState->getKey()],
                    'faveShape' => $this->getStateShape($introspectedState)
                )
            );
        }

        return $jsonableStates;
    }

    /**
     * @param IntrospectedTransition[] $introspectedTransitions
     * @param string[] $colors
     *
     * @return array
     */
    private function createTransitionsRepresentation(array $introspectedTransitions, array $colors)
    {
        $jsonableTransitions = array();
        foreach ($introspectedTransitions as $introspectedTransition) {
            $jsonableTransitions[] = array(
                'data' => array(
                    'source' => $introspectedTransition->getFromIntrospectedState()->getKey(),
                    'target' => $introspectedTransition->getToIntrospectedState()->getKey(),
                    'faveColor' => $colors[$introspectedTransition->getFromIntrospectedState()->getKey()],
                    'strength' => self::DEFAULT_TRANSITION_STRENGTH
                )
            );
        }

        return $jsonableTransitions;
    }

    /**
     * @param IntrospectedState[] $introspectedStates
     *
     * @return string[]
     */
    private function generateStatesUniqColor(array $introspectedStates)
    {
        $colors = array();
        foreach ($introspectedStates as $introspectedState) {
            $colors[$introspectedState->getKey()] = '#6FB1FC';
        }

        return $colors;
    }

    /**
     * @param IntrospectedState $introspectedState
     *
     * @return string
     */
    private function getStateShape(IntrospectedState $introspectedState)
    {
        if ($introspectedState->isRoot()) {
            return self::STATE_SHAPE_ROOT;
        }

        if ($introspectedState->isLeaf()) {
            return self::STATE_SHAPE_LEAF;
        }

        return self::STATE_SHAPE_NORMAL;
    }
}
