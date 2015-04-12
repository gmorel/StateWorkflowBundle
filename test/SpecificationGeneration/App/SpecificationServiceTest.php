<?php

namespace Test\StateWorkflowBundle\SpecificationGeneration\App;

use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateCancelled;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateIncomplete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StatePaid;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateToDelete;
use Gmorel\StateWorkflowBundle\Demo\BookingEngine\Domain\State\Implementation\StateWaitingPayment;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command\RenderWorkflowSpecificationFromWorkflowServiceCommand;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\WorkflowContainer;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Infra\CytoscapeSpecificationRepresentationGenerator;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\SpecificationService as SUT;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class SpecificationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_introspect_workflow_states()
    {
        // Given
        $stateWorkflow = $this->createValidStateWorkflow();
        $outputFileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.html';

        $command = new RenderWorkflowSpecificationFromWorkflowServiceCommand(
            $stateWorkflow->getKey(),
            $outputFileName
        );
        $workflowContainer = new WorkflowContainer();
        $workflowContainer->addWorkflow($stateWorkflow);

        $introspectedWorkflow = new SUT(
            $workflowContainer,
            new CytoscapeSpecificationRepresentationGenerator()
        );

        $expected = '<!DOCTYPE html>
<html>
    <head>
        <link href="../../SpecificationGeneration/UI/Resource/style.css" rel="stylesheet" />
        <meta charset=utf-8 />
        <titleBooking Workflow Specification</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
        <script src="../../SpecificationGeneration/UI/Resource/code.js"></script>
        <script type="application/javascript">
            var dataWorkflow = {"nodes":[{"data":{"id":"incomplete","name":"Incomplet","weight":50,"faveColor":"#6FB1FC","faveShape":"triangle"}},{"data":{"id":"waiting_for_payment","name":"En attente de paiement","weight":50,"faveColor":"#6FB1FC","faveShape":"rectangle"}},{"data":{"id":"paid","name":"Pay\u00e9","weight":50,"faveColor":"#6FB1FC","faveShape":"ellipse"}},{"data":{"id":"cancelled","name":"Annul\u00e9","weight":50,"faveColor":"#6FB1FC","faveShape":"rectangle"}},{"data":{"id":"to_delete","name":"A supprimer","weight":50,"faveColor":"#6FB1FC","faveShape":"ellipse"}}],"edges":[{"data":{"source":"incomplete","target":"waiting_for_payment","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"incomplete","target":"paid","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"waiting_for_payment","target":"paid","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"waiting_for_payment","target":"cancelled","faveColor":"#6FB1FC","strength":20}},{"data":{"source":"cancelled","target":"to_delete","faveColor":"#6FB1FC","strength":20}}]};
        </script>
    </head>

    <body>
        <div id="cy"></div>
    </body>
</html>
';

        // When
        $introspectedWorkflow->renderSpecification($command);
        $actual = file_get_contents($outputFileName);

        // Then
        $this->assertEquals($expected, $actual, 'Workflow Specification is not well rendered anymore.');
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
