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
        <?php if (isset($_SESSION['user'])): ?>
            <div>
                <?php if (isset($_SESSION['user']['email'])): ?>
                    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['email']); ?> !</p>
                <?php endif; ?>
            </div>

            <ul>
                <li><a href="search.php">Recherche</a></li>

                <li><a href="house.php">House</a></li>
                <li><a href="appartment.php">Appartement</a></li>

                <?php if (isset($_SESSION['user']['role']) && in_array($_SESSION['user']['role'], ['agent', 'admin'])): ?>
                    <li><a href="favorites.php">Mes favoris</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li>
                        <div class="add-btn"><a href="addanoncement.php">Add +</a></div>
                    </li>
                <?php else: ?>
                    <li><a href="favorites.php">Mes favoris</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <ul>
                <li><a href="login.php">Login</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</body>

</html>