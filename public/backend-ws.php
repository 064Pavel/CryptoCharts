<?php

\Ratchet\Client\connect('wss://stream.bybit.com/v5/public/linear')->then(function($conn) {
    $conn->on('message', function($msg) use ($conn) {
        $data = json_decode($msg, true);
        if ($data) {
            dump($data);
        }
    });

    $topic = 'kline.120.BTCUSDT';
    $params = [
        'op' => 'subscribe',
        'args' => [$topic],
    ];

    sleep(5);

    $conn->send(json_encode($params));
}, function ($e) {
    echo "Could not connect: {$e->getMessage()}\n";
});