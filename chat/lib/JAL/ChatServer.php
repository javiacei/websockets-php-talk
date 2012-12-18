<?php

namespace JAL;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface
{
    protected $clients;

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
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // Envio del correo a todos los clientes excepto al emisor
                echo "Enviando mesage '$msg' de {$from->resourceId}\n";
                $client->send($from->resourceId . ' >> ' . $msg);
            }
        }
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
}
