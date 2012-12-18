<?php

$client = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PUB, "logger");
$client->connect("tcp://127.0.0.1:5555");

$client->send($argv[1]);
