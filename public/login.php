<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <div class="container">
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
</body>
</html>
