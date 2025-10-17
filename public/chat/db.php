<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/../../database/social-network.sqlite'); // adjust path
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON;');
?>
