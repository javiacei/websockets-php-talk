<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use JAL\ChatServer;

require __DIR__ . '/vendor/autoload.php';

$server = IoServer::factory(
    new WsServer(
        new ChatServer()
    ),
    1232
);

$server->run();
