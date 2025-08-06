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
        <input type="file" id="image" name="image" required />
      </div>

      <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" required />
      </div>

      <div class="form-group">
        <label for="prix">Prix (€)</label>
        <input type="number" id="prix" name="prix" required min="0" />
      </div>

      <div class="form-group">
        <label for="ville">Ville</label>
        <input type="text" id="ville" name="ville" required />
      </div>

      <div class="form-group">
        <label for="description">Description courte</label>
        <textarea id="description" name="description" rows="4" required></textarea>
      </div>

     <div class="form-group">
        <label for="type">propertyType</label>
        <select id="type" name="type" required>
          <option value="">-- Sélectionnez --</option>
          <option value="house">House</option>
          <option value="apartment">Apartment</option>
        </select>
      </div>

      <div class="form-group">
        <label for="type">Type</label>
        <select id="type" name="type" required>
          <option value="">-- Sélectionnez --</option>
          <option value="rent">Rent</option>
          <option value="sale">Sale</option>
        </select>
      </div>

      <button type="submit">Enregistrer</button>
    </form>

    <div class="confirmation" id="confirmationMessage" style="display: none;">
       Annonce enregistrée avec succès !
    </div>
    <a href="/" class="return">← Retour à l’accueil</a>
  </main>
 <?php
 require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
  </div>

</body>
</html>
