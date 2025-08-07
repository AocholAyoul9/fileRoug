<?php
session_start();
require 'dbconnect.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM listing WHERE id = ?");
$stmt->execute([$id]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    echo "Annonce introuvable.";
    exit;
}

$user = $_SESSION['user'] ?? null;
if (!$user || ($listing['user_id'] != $user['id'] && $user['role'] !== 'admin')) {
    echo "Vous n'avez pas le droit de modifier cette annonce.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update = $pdo->prepare("UPDATE listing SET title = ?, description = ?, price = ?, updated_at = NOW() WHERE id = ?");
    $update->execute([$_POST['title'], $_POST['description'], $_POST['price'], $id]);
    header('Location: index.php');
    exit;
}
?>

<form method="POST">
    <input name="title" value="<?= htmlspecialchars($listing['title']) ?>"><br>
    <textarea name="description"><?= htmlspecialchars($listing['description']) ?></textarea><br>
    <input name="price" type="number" value="<?= $listing['price'] ?>"><br>
    <button type="submit">Modifier</button>
</form>
