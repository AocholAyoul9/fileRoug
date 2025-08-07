<?php
session_start();
require 'dbconnect.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM listing WHERE id = ?");
$stmt->execute([$id]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

$user = $_SESSION['user'] ?? null;
if (!$user || ($listing['user_id'] != $user['id'] && $user['role'] !== 'admin')) {
    echo "Accès interdit.";
    exit;
}

$pdo->prepare("DELETE FROM listing WHERE id = ?")->execute([$id]);
header('Location: index.php');
exit;
