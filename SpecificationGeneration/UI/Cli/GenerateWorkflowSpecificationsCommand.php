<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Cli;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command\RenderWorkflowSpecificationFromWorkflowServiceCommand;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\SpecificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class GenerateWorkflowSpecificationsCommand extends Command
{
    /** @var SpecificationService */
    private $specificationService;

    public function __construct(SpecificationService $specificationService)
    {
        parent::__construct();
        $this->specificationService = $specificationService;
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
        // @todo add parameters
        $command = new RenderWorkflowSpecificationFromWorkflowServiceCommand(
            'demo.booking_engine.state_workflow',
            '/home/gmorel/dev/www/StateWorkflowBundle/specification/workflow'
        );

        $output->write(
            sprintf(
                'Generating "%s" workflow specification.',
                $command->getWorkFlowServiceId()
            )
        );

        $this->specificationService->renderSpecification($command);

        $output->write(
            sprintf(
                'Workflow specification generated in "%".',
                $command->getOutputFileName()
            )
        );
    }
}
