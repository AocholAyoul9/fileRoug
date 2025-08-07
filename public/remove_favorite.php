<?php
session_start();
require 'dbconnect.php';

if (!isset($_SESSION['user']) || !isset($_POST['listing_id'])) {
    header('Location: index.php'); exit;
}

$pdo->prepare("DELETE FROM favorite WHERE user_id = ? AND listing_id = ?")
    ->execute([$_SESSION['user']['id'], $_POST['listing_id']]);

header('Location: index.php');
