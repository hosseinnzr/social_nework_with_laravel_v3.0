<?php
namespace social_network;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class Chat implements MessageComponentInterface {
    protected $clients;
    protected $userConnections = [];  // اضافه کردن این خط برای ذخیره اتصالات کاربران

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    
        // گرفتن username و target_user از Query String
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);
    
        if (isset($queryArray['username'])) {
            $conn->username = $queryArray['username'];
            $this->userConnections[$conn->username] = $conn; // اتصال رو ذخیره می‌کنیم
        }
    
        echo "New connection! ({$conn->resourceId}) Username: {$conn->username}\n";
    
        // اگر target_user هم موجود باشه، پیام‌های بین این دو نفر رو لود می‌کنیم
        if (isset($queryArray['target_user'])) {
            $targetUser = $queryArray['target_user'];
    
            // لود پیام‌های بین username و target_user
            $messages = $this->loadMessages($conn->username, $targetUser);
    
            // ارسال پیام‌ها به فرانت‌اند
            foreach ($messages as $message) {
                $conn->send(json_encode([
                    'user' => $message['sender_id'],
                    'message' => $message['body'],
                    'created_at' => $message['created_at']
                ]));
            }
        }
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
    
        if (!isset($data['type'])) {
            return;
        }
    
        if ($data['type'] == 'private' && isset($data['target'])) {
            $targetUsername = $data['target'];
    
            if (isset($this->userConnections[$targetUsername])) {
                $targetConn = $this->userConnections[$targetUsername];
    
                $targetConn->send(json_encode([
                    'user' => $data['user'],
                    'message' => $data['message'],
                    'created_at' => date('Y-m-d H:i:s')
                ]));
            }
    
            $this->saveMessage($data['user'], $data['target'], $data['message']);
        } 
        elseif ($data['type'] == 'typing' && isset($data['target'])) {
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
    
    
    
    private function saveMessage($sender, $receiver, $body) {
        $pdo = new \PDO('mysql:host=localhost;dbname=social_network;charset=utf8mb4', 'root', ''); // اطلاعات دیتابیس خودت رو جایگزین کن
        $stmt = $pdo->prepare('INSERT INTO messages (body, sender_id, receiver_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())');
        $stmt->execute([$body, $sender, $receiver]);
    }

    // بارگذاری پیام‌ها بین دو کاربر از دیتابیس
    private function loadMessages($sender, $receiver) {
        $pdo = new \PDO('mysql:host=localhost;dbname=social_network;charset=utf8mb4', 'root', ''); // به یاد داشته باش که اطلاعات دیتابیس خودت رو وارد کنی.
        $stmt = $pdo->prepare('SELECT body, sender_id, created_at FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC');
        $stmt->execute([$sender, $receiver, $receiver, $sender]);
        
        $messages = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $messages[] = $row;
        }

        return $messages;
    }


    public function onClose(ConnectionInterface $conn) {
        // اگر یوزرنیم برای این اتصال ثبت شده بود، حذفش می‌کنیم
        if (isset($conn->username)) {
            unset($this->userConnections[$conn->username]);
            echo "User {$conn->username} ({$conn->resourceId}) has disconnected\n";
        } else {
            echo "Connection {$conn->resourceId} has disconnected (no username)\n";
        }
    
        // اتصال رو از لیست کلی حذف می‌کنیم
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred with connection {$conn->resourceId}: {$e->getMessage()}\n";
    
        // اگر یوزرنیم ثبت شده، اتصالش رو حذف کنیم
        if (isset($conn->username)) {
            unset($this->userConnections[$conn->username]);
            echo "User {$conn->username} removed due to error.\n";
        }
    
        $this->clients->detach($conn); // از لیست کلاینت‌ها جدا کنیم
        $conn->close(); // اتصال رو ببندیم
    }
    
}

// composer dumpautoload