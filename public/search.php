<?php
require_once 'init.php';
require_once 'dbconnect.php';

$propertyTypes = $pdo->query("SELECT id, name FROM propertyType")->fetchAll();
$transactionTypes = $pdo->query("SELECT id, name FROM transactionType")->fetchAll();

$ville = isset($_GET['ville']) ? trim($_GET['ville']) : '';
$prix_max = isset($_GET['prix_max']) ? (int) $_GET['prix_max'] : 0;
$type_bien = isset($_GET['type_bien']) ? (int) $_GET['type_bien'] : 0;
$type_transaction = isset($_GET['type_transaction']) ? (int) $_GET['type_transaction'] : 0;

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
    WHERE 1 = 1
";

$params = [];

if ($ville !== '') {
    $sql .= " AND l.city LIKE :ville";
    $params[':ville'] = '%' . $ville . '%';
}

if ($prix_max > 0) {
    $sql .= " AND l.price <= :prix_max";
    $params[':prix_max'] = $prix_max;
}

if ($type_bien > 0) {
    $sql .= " AND l.property_type_id = :type_bien";
    $params[':type_bien'] = $type_bien;
}

if ($type_transaction > 0) {
    $sql .= " AND l.transaction_type_id = :type_transaction";
    $params[':type_transaction'] = $type_transaction;
}

$sql .= " ORDER BY l.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de biens</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../app/views/partials/header.php'; ?>

<div class="content">
    <h2>Recherche de biens immobiliers</h2>

    <form method="GET" action="search.php" class="search-form">
        <label>
            Ville :
            <input type="text" name="ville" value="<?= htmlspecialchars($ville) ?>">
        </label>

        <label>
            Prix maximum :
            <input type="number" name="prix_max" value="<?= $prix_max ?: '' ?>">
        </label>

        <label>
            Type de bien :
            <select name="type_bien">
                <option value="0">-- Tous --</option>
                <?php foreach ($propertyTypes as $type): ?>
                    <option value="<?= $type['id'] ?>" <?= $type_bien == $type['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Type de transaction :
            <select name="type_transaction">
                <option value="0">-- Tous --</option>
                <?php foreach ($transactionTypes as $tt): ?>
                    <option value="<?= $tt['id'] ?>" <?= $type_transaction == $tt['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tt['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <button type="submit">Rechercher</button>
    </form>

    <div class="annonces">
        <?php if (count($listings) > 0): ?>
            <?php foreach ($listings as $listing): ?>
                <div class="annonce">
                    <img src="<?= $listing['image_url'] ?>" alt="<?= htmlspecialchars($listing['title']) ?>">
                    <h3><?= htmlspecialchars($listing['title']) ?></h3>
                    <p><strong>Prix :</strong> <?= $listing['price'] ?></p>
                    <p><strong>Ville :</strong> <?= htmlspecialchars($listing['city']) ?></p>
                    <p><?= htmlspecialchars($listing['description']) ?></p>
                    <p><strong>Type :</strong> <?= htmlspecialchars($listing['property_type']) ?></p>
                    <p><strong>Transaction :</strong> <?= htmlspecialchars($listing['transaction_type']) ?></p>
                    <p><strong>Posté par :</strong> <?= htmlspecialchars($listing['user_email']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune annonce trouvée pour les critères sélectionnés.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
</body>
</html>
