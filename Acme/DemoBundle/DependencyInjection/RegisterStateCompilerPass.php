<?php
/**
 * Created by PhpStorm.
 * Date: 2/26/14
 * Time: 3:30 PM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Class RegisterStateCompilerPass
 * Register all Item State
 *
 */
class RegisterStateCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container Container
     *
     * @throws \Symfony\Component\Form\Exception\InvalidConfigurationException
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('acme.demo.state.manager')) {
            throw new InvalidConfigurationException('Cant find acme.demo.state.manager service');
        }

        $definition = $container->getDefinition('acme.demo.state.manager');

        $services = $container->findTaggedServiceIds('acme.demo.default.state');

        foreach ($services as $id => $attributes) {
            $definition->addMethodCall('addAvailableState', array(new Reference($id)));
        }
    }
} 