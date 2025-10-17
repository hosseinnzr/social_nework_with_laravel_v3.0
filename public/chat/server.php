<?php
// Include Composer autoloader
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use social_network\Chat; // Your Chat class implementing Ratchet\MessageComponentInterface
use React\Socket\Server as Reactor;
use React\EventLoop\Factory as LoopFactory;

// Create ReactPHP event loop
$loop = LoopFactory::create();

// Create a socket listening on all interfaces at port 8080
$socket = new Reactor('0.0.0.0:8080', $loop);

// Create WebSocket server
$server = new IoServer(
    new HttpServer(
        new WsServer(
            new Chat() // Your chat handler
        )
    ),
    $socket,
    $loop
);

// Run the server
$server->run();
