<?php

namespace JAL\Bundle\TaskBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RegisterTaskListenersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false == $container->hasDefinition('event_dispatcher')) {
            return;
        }

        $definition = $container->getDefinition('event_dispatcher');

        foreach ($container->findTaggedServiceIds('jal_task.event_listener') as $id => $events) {
            foreach ($events as $event) {

                $priority = isset($event['priority']) ? $event['priority'] : 0;

                if (!isset($event['event'])) {
                    throw new \InvalidArgumentException(
                        sprintf('Field \'event\' is required.')
                    );
                }

                if (!isset($event['method'])) {
                    throw new \InvalidArgumentException(
                        sprintf('Field \'method\' is required.')
                    );
                }

                $definition->addMethodCall(
                    'addListenerService',
                    array(
                        $event['event'],
                        array($id, $event['method']),
                        $priority
                    )
                );

            }
        }
    }
}
