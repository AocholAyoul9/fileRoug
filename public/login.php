<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/login.css">

    <title>login</title>
</head>
<body>
    <?php
    require_once __DIR__ . '/../app/views/partials/header.php'; ?>
<div class="container">
    <div class="contianer-items">
         <h2>Connexion à Find My Dream Home</h2>
         <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Se connecter</button>
          </form>
        <div class="link">
            <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
        </div>
    </div>
</div>
    <?php
    require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
</body>
</html>
