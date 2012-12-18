<?php

use Ratchet\Server\IoServer;
use JAL\ChatServer;

require __DIR__ . '/vendor/autoload.php';

$server = IoServer::factory(
    new ChatServer(),
    1231,
    '127.0.0.1'
);

$server->run();
