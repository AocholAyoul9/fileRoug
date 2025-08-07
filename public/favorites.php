<?php
session_start();
require 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT l.*
    FROM listing l
    JOIN favorite f ON f.listing_id = l.id
    WHERE f.user_id = ?
");
$stmt->execute([$_SESSION['user']['id']]);
$favorites = $stmt->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mes favoris</title>
</head>

<body>
    <?php
    require_once __DIR__ . '/../app/views/partials/header.php'; ?>
    <main>
        <h1>Mes favoris</h1>
        <?php foreach ($favorites as $fav): ?>
            <img src="<?php echo $fav['image_url'] ?>" alt="<?php echo $fav['title'] ?>">
                        <h3><?php echo $fav['title'] ?></h3>
                        <p> <strong>Prix:</strong> <?php echo $fav['price'] ?></p>
                        <p><strong>Ville :</strong> <?php echo $fav['city'] ?></p>
                        <p><?php echo $fav['description'] ?></p>
                        <p><strong>Type de bien :</strong> <?= htmlspecialchars($fav['property_type']) ?></p>
                        <p><strong>Transaction :</strong> <?= htmlspecialchars($fav['transaction_type']) ?></p>
                        <p><strong>Posté par :</strong> <?= htmlspecialchars($fav['user_email']) ?></p>
        <?php endforeach; ?>
    </main>

    <footer>
        <?php
        require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
    </footer>
</body>

</html>