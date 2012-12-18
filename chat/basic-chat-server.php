<?php

use Ratchet\Server\IoServer;
use JAL\ChatServer;

require __DIR__ . '/vendor/autoload.php';

$server = IoServer::factory(
    new ChatServer(),
    1231
);

$server->run();
