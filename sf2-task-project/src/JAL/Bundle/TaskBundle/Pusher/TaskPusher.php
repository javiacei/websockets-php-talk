<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Pusher;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class TaskPusher implements WampServerInterface
{
    protected $clients;

    protected $subscribedTopics = array();

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Guardamos la nueva conexión para el posterior envio de mensajes
        $this->clients->attach($conn);

        echo "Se ha conectado cliente con id de recurso: " . $conn->resourceId . "\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // No permitiré el cambio desde el ws de los cliente
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Borrar el cliente de la colección del cliente para no realizar envios
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";

        $conn->close();
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // No se permite gestionar la cola de mensajes desde consola
        $conn->callError($id, $topic, 'No tienes permiso para acceder a la cola de mensajes desde consola')->close();
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // No se permite gestionar la cola de mensajes desde consola
        $conn->close();
    }

    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        // No la utilizaré
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // No la utilizaré
    }

    public function onTaskModification($entry)
    {
        // Aviso a todos los cliente del cambio en el estado de la tarea
        foreach ($this->clients as $client) {
            $client->send($entry);
        }
    }
}
