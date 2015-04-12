<?php

namespace Gmorel\StateWorkflowBundle\Kernel\AppBundle;

use Gmorel\StateWorkflowBundle\DependencyInjection\RegisterStateWorkflowCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class StateWorkflowBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterStateWorkflowCompilerPass());
    }
}
