<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$films = simplexml_load_file('../xml/films.xml');
if ($films === false) {
    echo "Failed to load XML file.";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Films</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
    <div class="container">
    <header>
        <h1>Bienvenue sur le Portail Cinéma et Restaurants</h1>
        <nav>
            <ul>
                <li><a href="">Voir les films</a></li>
                <li><a href="afficher_restaurants.php">Voir les restaurants</a></li>
                <li><a href="../admin/login.php">Admin</a></li>
            </ul>
        </nav>
    </header>
        <h1>Liste des Films</h1>
        <?php foreach ($films->film as $film): ?>
            <div class="film">
                <h2><?php echo htmlspecialchars($film->titre, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($film->genre, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Durée:</strong> <?php echo htmlspecialchars($film->duree, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Réalisateur:</strong> <?php echo htmlspecialchars($film->realisateur, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Langue:</strong> <?php echo htmlspecialchars($film->langue, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Année:</strong> <?php echo htmlspecialchars($film->annee, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Synopsis:</strong> <?php echo htmlspecialchars($film->synopsis, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Acteurs:</strong> <?php echo htmlspecialchars(implode(", ", (array)$film->acteurs->acteur), ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        <p>&copy; 2024 Portail Cinéma et Restaurants. Tous droits réservés.</p>
    </footer>
</body>
</html>
