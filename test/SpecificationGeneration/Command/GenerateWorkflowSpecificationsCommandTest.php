<?php

namespace Test\StateWorkflowBundle\SpecificationGeneration\Command;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\Command\GenerateWorkflowSpecificationsCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class GenerateWorkflowSpecificationsCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new GenerateWorkflowSpecificationsCommand());

        $command = $application->find('gmorel:state-engine:generate-workflow-specifications');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
    }
}
