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
    <h2>Nos annonces de maison</h2>
    <div class="annonces">
        <?php foreach ($maisons as $maison): ?>
            <div class="annonce">
                <img src="<?php echo $maison['image'] ?>" alt="<?php echo $maison['titre'] ?>">
                <h3><?php echo $maison['titre'] ?></h3>
                <p> Prix :<?php echo $maison['prix'] ?></p>
                <p><?php echo $maison['ville'] ?></p>
                <p><?php echo $maison['description'] ?></p>
                <p> Type :<?php echo $maison['type'] ?></p>
                <a class="contact-btn" href="#">Contact</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <h2>Nos annonces d’appartements</h2>
    <div class="annonces">
        <?php foreach ($appartements as $appartement): ?>
            <div class="annonce">
                <img src="<?php echo $appartement['image'] ?>">
                <h3><?php echo $appartement['titre'] ?></h3>
                <p> Prix :                                                                                                         <?php echo $appartement['prix'] ?></p>
                <p>Ville :                                                                                                         <?php echo $appartement['ville'] ?></p>
                <p><?php echo $appartement['description'] ?></p>
                <p> Type :                                                                                                          <?php echo $appartement['type'] ?></p>
                <a class="contact-btn" href="#">Contact</a>
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
