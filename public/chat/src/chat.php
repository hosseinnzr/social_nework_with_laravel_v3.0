<?php
namespace social_network;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $userConnections = [];  // Store connected users

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        // Get username and target_user from query string
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);

        if (isset($queryArray['username'])) {
            $conn->username = $queryArray['username'];
            $this->userConnections[$conn->username] = $conn; // Store connection
        }

        echo "New connection! ({$conn->resourceId}) Username: {$conn->username}\n";

        // If target_user is set, load messages between these two users
        if (isset($queryArray['target_user'])) {
            $targetUser = $queryArray['target_user'];

            // Load messages between username and target_user
            $messages = $this->loadMessages($conn->username, $targetUser);

            // Send messages to frontend
            foreach ($messages as $message) {
                $conn->send(json_encode([
                    'user' => $message['sender'],
                    'message' => $message['body'],
                    'created_at' => $message['created_at']
                ]));
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (!isset($data['type'])) return;

        if ($data['type'] === 'private' && isset($data['target'])) {
            $targetUsername = $data['target'];

            // Send message to target user if connected
            if (isset($this->userConnections[$targetUsername])) {
                $targetConn = $this->userConnections[$targetUsername];
                $targetConn->send(json_encode([
                    'user' => $data['user'],
                    'message' => $data['message'],
                    'created_at' => date('Y-m-d H:i:s')
                ]));
            }

            // Save message to SQLite database
            $this->saveMessage($data['user'], $data['target'], $data['message']);
        }
        elseif ($data['type'] === 'typing' && isset($data['target'])) {
            $targetUsername = $data['target'];

            if (isset($this->userConnections[$targetUsername])) {
                $targetConn = $this->userConnections[$targetUsername];
                $targetConn->send(json_encode([
                    'type' => 'typing',
                    'user' => $data['user']
                ]));
            }
        }
    }

    // Save private message to SQLite database
    private function saveMessage($sender, $receiver, $body) {
        $pdo = new \PDO('sqlite:' . __DIR__ . '/../../../database/social-network.sqlite');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON;');

        $stmt = $pdo->prepare('
            INSERT INTO messages (body, sender, receiver, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?)
        ');

        $now = date('Y-m-d H:i:s');
        $stmt->execute([$body, $sender, $receiver, $now, $now]);
    }

    // Load messages between two users from SQLite database
    private function loadMessages($sender, $receiver) {
        $pdo = new \PDO('sqlite:' . __DIR__ . '/../../../database/social-network.sqlite');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON;');

        $stmt = $pdo->prepare('
            SELECT body, sender, created_at
            FROM messages
            WHERE (sender = ? AND receiver = ?)
               OR (sender = ? AND receiver = ?)
            ORDER BY created_at ASC
        ');

        $stmt->execute([$sender, $receiver, $receiver, $sender]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove connection from userConnections if username exists
        if (isset($conn->username)) {
            unset($this->userConnections[$conn->username]);
            echo "User {$conn->username} ({$conn->resourceId}) has disconnected\n";
        } else {
            echo "Connection {$conn->resourceId} has disconnected (no username)\n";
        }

        // Detach connection from the clients list
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error occurred with connection {$conn->resourceId}: {$e->getMessage()}\n";

        if (isset($conn->username)) {
            unset($this->userConnections[$conn->username]);
            echo "User {$conn->username} removed due to error.\n";
        }

        $this->clients->detach($conn);
        $conn->close();
    }
}
