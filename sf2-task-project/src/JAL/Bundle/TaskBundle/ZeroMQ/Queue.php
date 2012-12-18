<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\ZeroMQ;

class Queue
{
    protected $socket;

    public function __construct(/*$host*/)
    {
        $host = "tcp://0.0.0.0:5555";

        $this->socket = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PUSH, "logger");
        $this->socket->connect($host);
    }

    public function send(array $message)
    {
        $this->socket->send(\json_encode($message));
    }
}
