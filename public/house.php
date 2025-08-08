<?php
include 'init.php';
include 'dbconnect.php';

$itemsPerPage = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;

$countStmt = $pdo->prepare("
    SELECT COUNT(*) FROM listing l
    JOIN propertyType pt ON l.property_type_id = pt.id
    WHERE pt.name = 'Maison'
");
$countStmt->execute();
$totalListings = $countStmt->fetchColumn();
$totalPages = ceil($totalListings / $itemsPerPage);

if ($page > $totalPages && $totalPages > 0) {
    header("Location: house.php?page=1");
    exit();
}

$offset = ($page - 1) * $itemsPerPage;

$stmt = $pdo->prepare("
    SELECT 
        l.*, 
        pt.name AS property_type, 
        tt.name AS transaction_type, 
        u.email AS user_email
    FROM listing l
    JOIN propertyType pt ON l.property_type_id = pt.id
    JOIN transactionType tt ON l.transaction_type_id = tt.id
    JOIN user u ON l.user_id = u.id
    WHERE pt.name = 'House'
    ORDER BY l.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Maisons - Find My Dream Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once __DIR__ . '/../app/views/partials/header.php'; ?>

    <div class="content">
        <section>
            <h2>Liste des maisons</h2>
            <div class="annonces">
                <?php foreach ($listings as $listing): ?>
                    <div class="annonce">
                        <img src="<?= $listing['image_url'] ?>" alt="<?= htmlspecialchars($listing['title']) ?>">
                        <h3><?= htmlspecialchars($listing['title']) ?></h3>
                        <p><strong>Prix :</strong> <?= htmlspecialchars($listing['price']) ?></p>
                        <p><strong>Ville :</strong> <?= htmlspecialchars($listing['city']) ?></p>
                        <p><?= htmlspecialchars($listing['description']) ?></p>
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
                                        <button type="submit" class="btn-retirer">Retirer des favoris</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="add_favorite.php">
                                        <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                        <button type="submit" class="btn-favoris">Ajouter aux favoris</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- PAGINATION -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>">&laquo; Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <strong class="active"><?= $i ?></strong>
                        <?php else: ?>
                            <a href="?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>">Suivant &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
</body>

</html>