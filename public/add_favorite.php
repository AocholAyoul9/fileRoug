<?php
session_start();
require 'dbconnect.php';

if (!isset($_SESSION['user']) || !isset($_POST['listing_id'])) {
    header('Location: index.php'); exit;
}

$pdo->prepare("INSERT IGNORE INTO favorite (user_id, listing_id) VALUES (?, ?)")
    ->execute([$_SESSION['user']['id'], $_POST['listing_id']]);

header('Location: index.php');
