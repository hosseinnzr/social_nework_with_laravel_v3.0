<?php
$pdo = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
