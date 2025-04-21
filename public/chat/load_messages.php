<?php
session_start();
require 'db.php'; // فایل اتصال دیتابیس

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$loggedInUser = $_SESSION['user']; // فرض میگیریم در login.php ذخیره کردی
$targetUser = $_POST['target_user'] ?? '';

if (!$targetUser) {
    echo json_encode([]);
    exit;
}

// گرفتن مکالمات بین دو کاربر
$stmt = $pdo->prepare("
    SELECT * FROM messages 
    WHERE (sender_id = :user1 AND receiver_id = :user2) 
       OR (sender_id = :user2 AND receiver_id = :user1)
    ORDER BY created_at ASC
");
$stmt->execute([
    'user1' => $loggedInUser,
    'user2' => $targetUser
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>
