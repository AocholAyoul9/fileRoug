<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/header.css">
    <title>header</title>
</head>
<body>
    <nav>
    <h1><a href="/">Find My Dream Home</a></h1>
    <ul>
             <li><a href="#">House</a></li>
        <li><a href="#">Appartement</a></li>
     <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['email'])): ?>
    <a href="logout.php">Logout</a>
    <div class="add-btn"><a href="addanoncement.php">Add +</a></div>
    <?php else: ?>
    <a href="login.php">Login</a>
    <?php endif; ?>

    </ul>
</nav>
</body>
</html>
