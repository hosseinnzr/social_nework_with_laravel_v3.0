<?php
// require 'vendor/autoload.php';
// use Ratchet\Server\IoServer;
// use social_network\Chat;
// use Ratchet\Http\HttpServer;
// use Ratchet\WebSocket\WsServer;

// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat()
//         )
//     ),
//     8080
// );
// $server->run();

require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use social_network\Chat;
use React\Socket\Server as Reactor;
use React\EventLoop\Factory as LoopFactory;

$loop = LoopFactory::create();
$socket = new Reactor('0.0.0.0:8080', $loop);

$server = new IoServer(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $socket,
    $loop
);

$server->run();


// composer dumpautoload    