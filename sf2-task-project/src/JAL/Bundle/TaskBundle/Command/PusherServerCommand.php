<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use JAL\Bundle\TaskBundle\Pusher\TaskPusher;

class PusherServerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('task:pusher-server')
            ->setDescription('Servidor para las tareas')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop   = \React\EventLoop\Factory::create();
        $pusher = new TaskPusher();

        // Configuración para escuchar de ZeroMQ
        $context = new \React\ZMQ\Context($loop);

        // Configuramos el socket para realizar el loop y en cuanto llegue
        // un mensage a la cola, ejecutar el metodo del método on
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://0.0.0.0:5555');
        $pull->on('message', array($pusher, 'onTaskModification'));

        // Configuración del servidor WebSocket
        $webSock = new \React\Socket\Server($loop);
        $webSock->listen(1232, '0.0.0.0');
        $webServer = new \Ratchet\Server\IoServer(
            new \Ratchet\WebSocket\WsServer(
                new \Ratchet\Wamp\WampServer(
                    $pusher
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
