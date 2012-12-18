<?php

$server = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_SUB);
$server->setSockOpt(\ZMQ::SOCKOPT_SUBSCRIBE, '');
$server->bind("tcp://127.0.0.1:5555");

while ($message = $server->recv()) {
    echo "Recibido el mensage: $message\n";
}
