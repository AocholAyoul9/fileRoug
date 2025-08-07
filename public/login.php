<?php

include 'init.php';

include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

  $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
  $stmt->execute([$_POST['email'], $_POST['password']]);
  $user = $stmt->fetch();

  if ($user) {
    $_SESSION['user'] = $user;

    echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user['email']);
    header('Location: index.php');
    exit();
  } else {
    $error = "Identifiants incorrects";
  }
}
?>

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

      <?php if (isset($error)): ?>
        <p style="color:red"><?php echo htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="POST" id="loginForm">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <small id="errorMessage"></small>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <small id="errorMessage"></small>
        <small id="passwordStrength"></small>

        <button type="submit">Se connecter</button>
      </form>
      <div class="link">
        <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
      </div>
    </div>
  </div>
  <?php
  require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
  <script>

    const passwordInput = document.getElementById('password');
    const strengthText = document.getElementById('passwordStrength');
    const errorMessage = document.getElementById('errorMessage');

    passwordInput.addEventListener('input', () => {
      const value = passwordInput.value;

      if (value.length === 0) {
        strengthText.textContent = '';
      } else if (value.length > 8 && /[A-Z]/.test(value) && /[0-9]/.test(value)) {
        strengthText.textContent = 'Strong';
        strengthText.style.color = 'green';
      } else if (value.length >= 6) {
        strengthText.textContent = 'Medium';
        strengthText.style.color = 'orange';
      } else {
        strengthText.textContent = 'Weak';
        strengthText.style.color = 'red';
      }
    });

    document.getElementById('loginForm').addEventListener('submit', (e) => {

      e.preventDefault();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      let errorMessage = document.getElementById('errorMessage');


      errorMessage.textContent = '';

      if (!email || !password) {
        errorMessage.textContent = "All fields are required";
        return;
      }
      e.target.submit()
    })
  </script>
</body>

</html>