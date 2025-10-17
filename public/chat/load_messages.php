<?php
session_start();

// Connect to SQLite database
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/social-network.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON;'); // Enable foreign key constraints
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$loggedInUser = $_SESSION['user']; // Logged-in user
$targetUser = $_POST['target_user'] ?? '';

// If target user is not provided, return empty array
if (!$targetUser) {
    echo json_encode([]);
    exit;
}

// Fetch messages between the two users
try {
    $stmt = $pdo->prepare("
        SELECT * FROM messages
        WHERE (sender = :user1 AND receiver = :user2)
           OR (sender = :user2 AND receiver = :user1)
        ORDER BY created_at ASC
    ");
    $stmt->execute([
        'user1' => $loggedInUser,
        'user2' => $targetUser
    ]);

    // Fetch all messages as associative array
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return messages as JSON
    echo json_encode($messages);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
?>
