<?php
require_once 'init.php';
require_once 'dbconnect.php';

echo "Connexion réussie à la base de données !<br>";

if (!isset($_SESSION['user'])) {
    die("Vous devez être connecté pour voir vos favoris.");
}

$sql = "
    SELECT 
        l.*, 
        pt.name AS property_type, 
        tt.name AS transaction_type, 
        u.email AS user_email
    FROM favorite f
    JOIN listing l ON f.listing_id = l.id
    JOIN propertyType pt ON l.property_type_id = pt.id
    JOIN transactionType tt ON l.transaction_type_id = tt.id
    JOIN user u ON l.user_id = u.id
    WHERE f.user_id = :user_id
    ORDER BY l.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $_SESSION['user']['id']]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="assets/css/favorite.css">

    <title>Document</title>
</head>

<body>

 <?php
    require_once __DIR__ . '/../app/views/partials/header.php'; ?>

    <div class="favorites-container">
        <h2>Mes favoris</h2>

        <?php if (count($favorites) > 0): ?>
            <?php foreach ($favorites as $fav): ?>
                <div class="fav-annonce">
                    <img src="<?= htmlspecialchars($fav['image_url']) ?>" alt="<?= htmlspecialchars($fav['title']) ?>">

                    <div class="fav-details">
                        <h3><?= htmlspecialchars($fav['title']) ?></h3>
                        <p><strong>Prix :</strong> <?= $fav['price'] ?> €</p>
                        <p><strong>Ville :</strong> <?= htmlspecialchars($fav['city']) ?></p>
                        <p><strong>Type :</strong> <?= htmlspecialchars($fav['property_type']) ?></p>
                        <p><strong>Transaction :</strong> <?= htmlspecialchars($fav['transaction_type']) ?></p>
                        <p><strong>Posté par :</strong> <?= htmlspecialchars($fav['user_email']) ?></p>

                        <div class="fav-actions">
                            <form method="POST" action="remove_favorite.php">
                                <input type="hidden" name="listing_id" value="<?= $fav['id'] ?>">
                                <button type="submit">Retirer des favoris</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-favorites">Vous n'avez pas encore ajouté d'annonces aux favoris.</p>
        <?php endif; ?>
    </div>

</body>

</html>