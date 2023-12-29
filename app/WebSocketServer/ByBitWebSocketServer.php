<?php

namespace App\WebSocketServer;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class ByBitWebSocketServer implements MessageComponentInterface
{
    private $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Новое соединение! ({$conn->resourceId})\n";

        $this->subscribeToBybitCandles($conn, 'wss://stream.bybit.com/v5/public/inverse');
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Получено сообщение от клиента {$from->resourceId}: $msg\n";
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Соединение {$conn->resourceId} закрыто\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }

    private function subscribeToBybitCandles(ConnectionInterface $conn, $bybitWebSocketUrl) {
        $subscriptionRequest = json_encode([
            'op' => 'subscribe',
            'args' => ['klineV2.BTCUSD.1m'],
        ]);

        $conn->send($subscriptionRequest);
    }
}