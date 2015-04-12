<?php

namespace Gmorel\StateWorkflowBundle\Demo\Kernel\AppBundle;

use Gmorel\StateWorkflowBundle\Demo\Kernel\DependencyInjection\RegisterStateCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Guillaume MOREL <github.com/gmorel>
 */
class AppBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterStateCompilerPass());
    }
}
