<?php
include 'init.php';
include 'dbconnect.php';


if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'agent'])) {
    $_SESSION['error'] = "Accès refusé. Seuls les agents et administrateurs peuvent publier.";
    header('Location: index.php');
    exit();
}
$propertyTypes = $pdo->query("SELECT * FROM propertyType")->fetchAll(PDO::FETCH_ASSOC);
$transactionTypes = $pdo->query("SELECT * FROM transactionType")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $stmt = $pdo->prepare("  INSERT INTO listing (title, description, price, city, image_url, property_type_id, transaction_type_id, user_id, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

  $stmt->execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['price'],
    $_POST['city'],
    $_POST['image_url'] ?: null,
    $_POST['property_type_id'],
    $_POST['transaction_type_id'],
    1 // utilisateur connecté
  ]);

  echo "Annonce ajoutée avec succès.";

}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="assets/css/addAnonce.css">
  <title>Ajout d'annonce</title>
</head>

<body>
  <?php
  require_once __DIR__ . '/../app/views/partials/header.php'; ?>
  <main>

    <div class="container">
      <h2>Ajouter une annonce</h2>
      <form id="listingForm" method="post">
        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" id="image" name="image_url" required />
        </div>

        <div class="form-group">
          <label for="titre">Titre</label>
          <input type="text" id="titre" name="title" required />
        </div>

        <div class="form-group">
          <label for="prix">Prix (€)</label>
          <input type="number" id="prix" name="price" required min="0" />
        </div>

        <div class="form-group">
          <label for="ville">Ville</label>
          <input type="text" id="ville" name="city" required />
        </div>

        <div class="form-group">
          <label for="description">Description courte</label>
          <textarea id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
          <label for="type">propertyType</label>
          <select id="type" name="property_type_id" required>
            <option value="">-- Type de bien --</option>

            <?php foreach ($propertyTypes as $type): ?>
              <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?>

              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="type">Type</label>
          <select id="type" name="transaction_type_id" required>
            <option value="">-- Type de transaction --</option>
            <?php foreach ($transactionTypes as $tt): ?>
              <option value="<?= $tt['id'] ?>"><?= htmlspecialchars($tt['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit">Enregistrer</button>
      </form>

      <div class="confirmation" id="confirmationMessage" style="display: none;">
        Annonce enregistrée avec succès !
      </div>
      <a href="/" class="return">← Retour à l’accueil</a>
  </main>
 
  </div>
 <?php
  require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
</body>

</html>