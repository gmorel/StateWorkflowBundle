<?php

namespace Gmorel\StateWorkflowBundle\Demo\KernelBundle;

use Gmorel\StateWorkflowBundle\Demo\KernelBundle\DependencyInjection\RegisterBookingStateWorkflowCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class KernelBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterBookingStateWorkflowCompilerPass());
    }
}
