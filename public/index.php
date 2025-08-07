<?php
include 'init.php';
include 'dbconnect.php';


$sql = "
    SELECT 
        l.*, 
        pt.name AS property_type, 
        tt.name AS transaction_type, 
        u.email AS user_email
    FROM listing l
    JOIN propertyType pt ON l.property_type_id = pt.id
    JOIN transactionType tt ON l.transaction_type_id = tt.id
    JOIN user u ON l.user_id = u.id
    ORDER BY l.created_at DESC
";

$stmt = $pdo->query($sql);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Find My Dream Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php
    require_once __DIR__ . '/../app/views/partials/header.php'; ?>

    <div class="content">

        <?php
        require_once "data.php";
        ?>

        <section>
            <h2>Liste des annonces</h2>
            <div class="annonces">
                <?php foreach ($listings as $listing): ?>
                    <div class="annonce">
                        <img src="<?php echo $listing['image_url'] ?>" alt="<?php echo $listing['title'] ?>">
                        <h3><?php echo $listing['title'] ?></h3>
                        <p> <strong>Prix:</strong> <?php echo $listing['price'] ?></p>
                        <p><strong>Ville :</strong> <?php echo $listing['city'] ?></p>
                        <p><?php echo $listing['description'] ?></p>
                        <p><strong>Type de bien :</strong> <?= htmlspecialchars($listing['property_type']) ?></p>
                        <p><strong>Transaction :</strong> <?= htmlspecialchars($listing['transaction_type']) ?></p>
                        <p><strong>Posté par :</strong> <?= htmlspecialchars($listing['user_email']) ?></p>
                        <div class="action-buttons">

                            <a class="contact-btn" href="#">Contact</a>

                            <?php if (
                                isset($_SESSION['user']) &&
                                (
                                    $_SESSION['user']['id'] == $listing['user_id'] ||
                                    $_SESSION['user']['role'] === 'admin'
                                )
                            ): ?>
                                <a class="edit-btn" href="edit_listing.php?id=<?= $listing['id'] ?>">Modifier</a>
                            <?php endif; ?>

                            <?php if (
                                isset($_SESSION['user']) &&
                                (
                                    $_SESSION['user']['id'] == $listing['user_id'] ||
                                    $_SESSION['user']['role'] === 'admin'
                                )
                            ): ?>
                                <form method="POST" action="delete_listing.php"
                                    onsubmit="return confirm('Confirmer la suppression ?');">
                                    <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                    <button type="submit" class="btn-delete">Supprimer</button>
                                </form>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['user'])): ?>
                                <?php
                                $check = $pdo->prepare("SELECT * FROM favorite WHERE user_id = ? AND listing_id = ?");
                                $check->execute([$_SESSION['user']['id'], $listing['id']]);
                                $isFavorite = $check->fetch();
                                ?>

                                <?php if ($isFavorite): ?>
                                    <form method="POST" action="remove_favorite.php">
                                        <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                        <button type="submit">Retirer des favoris</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="add_favorite.php">
                                        <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                        <button type="submit">Ajouter aux favoris</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <footer>
        <?php
        require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
    </footer>

</body>

</html>