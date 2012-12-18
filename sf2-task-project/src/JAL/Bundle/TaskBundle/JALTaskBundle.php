<?php

namespace JAL\Bundle\TaskBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use JAL\Bundle\TaskBundle\DependencyInjection\Compiler\RegisterTaskListenersPass;

class JALTaskBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterTaskListenersPass());
    }
}
