<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\UI\Cli;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\Command\RenderWorkflowSpecificationFromWorkflowServiceCommand;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\App\SpecificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this->specificationService = $specificationService;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gmorel:state-engine:generate-workflow-specifications')
            ->setDescription('Generate workflow specifications')
            ->addOption(
                '--target-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Generated Workflow specification path directory.',
                $this->getDefaultSpecificationDirectory()
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->specificationService->getAvailableWorkflowIds() as $workflowId) {
            $specificationFileName = $input->getOption('target-path') . DIRECTORY_SEPARATOR . $workflowId . '.html';
            $command = new RenderWorkflowSpecificationFromWorkflowServiceCommand(
                $workflowId,
                $specificationFileName
            );

            $output->writeln(sprintf('Generating "%s" workflow specification.', $command->getWorkFlowServiceId()));
            $this->specificationService->renderSpecification($command);
            $output->writeln(sprintf('Workflow specification generated in "%s".', $specificationFileName));
        }
    }

    /**
     * @return string
     */
    private function getDefaultSpecificationDirectory()
    {
        return str_replace(
            '/',
            DIRECTORY_SEPARATOR,
            realpath(__DIR__ . '/../../../../../../../..')
        ) . DIRECTORY_SEPARATOR . 'specification/workflow';
    }
}
