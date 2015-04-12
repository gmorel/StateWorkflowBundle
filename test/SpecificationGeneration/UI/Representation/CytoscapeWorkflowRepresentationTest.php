<?php

namespace Gmorel\Test\StateWorkflowBundle\SpecificationGeneration\UI\Representation;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateIncomplete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StatePaid;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateToDelete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateWaitingPayment;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\IntrospectedWorkflow;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Representation\CytoscapeWorkflowRepresentation as SUT;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class CytoscapeWorkflowRepresentationTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_represent_itself_in_json()
    {
        // Given
        $stateWorkflow = $this->createValidStateWorkflow();
        $introspectedWorkflow = new IntrospectedWorkflow($stateWorkflow);

        $expected = '{"nodes":[{"data":{"id":"incomplete","name":"Incomplet","weight":50,"faveColor":"#6FB1FC","faveShape":"triangle"}},{"data":{"id":"waiting_for_payment","name":"En attente de paiement","weight":50,"faveColor":"#6FB1FC","faveShape":"rectangle"}},{"data":{"id":"paid","name":"Pay\u00e9","weight":50,"faveColor":"#6FB1FC","faveShape":"ellipse"}},{"data":{"id":"cancelled","name":"Annul\u00e9","weight":50,"faveColor":"#6FB1FC","faveShape":"rectangle"}},{"data":{"id":"to_delete","name":"A supprimer","weight":50,"faveColor":"#6FB1FC","faveShape":"ellipse"}}],"edges":[{"data":{"source":"incomplete","target":"waiting_for_payment","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"incomplete","target":"paid","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"waiting_for_payment","target":"paid","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"waiting_for_payment","target":"cancelled","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"cancelled","target":"to_delete","faveColor":"#6FB1FC","strength":20}}]}';

        // When
        $representation = new SUT($introspectedWorkflow);
        $actual = $representation->serialize();

        // Then
        $this->assertEquals($expected, $actual, 'State Workflow are not well represented in JSON Cytoscape anymore.');
    }

    /**
     * @return StateWorkflow
     */
    private function createValidStateWorkflow()
    {
        $stateIncomplete = new StateIncomplete();
        $stateWaitingPayment = new StateWaitingPayment();
        $statePaid = new StatePaid();
        $stateCancelled = new StateCancelled();
        $stateToDelete = new StateToDelete();

        $stateWorkflow = new StateWorkflow('Booking Workflow', 'key');
        $stateWorkflow->addAvailableState($stateIncomplete);
        $stateWorkflow->addAvailableState($stateWaitingPayment);
        $stateWorkflow->addAvailableState($statePaid);
        $stateWorkflow->addAvailableState($stateCancelled);
        $stateWorkflow->addAvailableState($stateToDelete);

        $stateWorkflow->setStateAsDefault($stateIncomplete->getKey());

        return $stateWorkflow;
    }
}
