<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Command;

use Gmorel\StateWorkflowBundle\StateEngine\Exception\UnsupportedStateTransitionException;
use Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class GenerateWorkflowSpecificationsCommand extends Command
{
    /** @var StateWorkflow[] */
    private $workflows = array();

    public function __construct()
    {
        parent::__construct();
    }


    public function addWorkflow(StateWorkflow $workflow)
    {
        $this->workflows[$workflow->getName()] = $workflow;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gmorel:state-engine:generate-workflow-specifications')
            ->setDescription('Generate workflow specifications')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->workflows as $workflow) {
            $availableStates = $workflow->getAvailableStates();

            if (!empty($availableStates)) {
                $methods = array();
                $reflection = new \ReflectionClass(get_class(reset($availableStates)));
                foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if ($method['class'] === $reflection->getName()) {
                        $methods[] = $method['name'];
                    }

                    foreach ($availableStates as $availableState) {
                        try {
                            $availableState->{$methods};
                            // Add transition
                        } catch (UnsupportedStateTransitionException $e) {

                        }
                    }
                }
            }
        }


        $output->write('kjhgfd');
    }
}
