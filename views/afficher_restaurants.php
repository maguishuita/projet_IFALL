<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$restaurants = simplexml_load_file('../xml/restaurants.xml');
if ($restaurants === false) {
    echo "Failed to load XML file.";
    foreach (libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Restaurants</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
    <header>
        <h1>Bienvenue sur le Portail Cinéma et Restaurants</h1>
        <nav>
            <ul>
                <li><a href="afficher_films.php">Voir les films</a></li>
                <li><a href="">Voir les restaurants</a></li>
                <li><a href="../admin/login.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    <h1>Liste des Restaurants</h1>
        <?php foreach ($restaurants->restaurant as $restaurant): ?>
            <div class="restaurant">
                <h2><?php echo htmlspecialchars($restaurant->coordonnees->nom, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><strong>Adresse:</strong> <?php echo htmlspecialchars($restaurant->coordonnees->adresse, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Nom du Restaurateur:</strong> <?php echo htmlspecialchars($restaurant->coordonnees->nomRestaurateur, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($restaurant->coordonnees->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php if (isset($restaurant->coordonnees->images->image)): ?>
                    <h3>Images</h3>
                    <?php foreach ($restaurant->coordonnees->images->image as $image): ?>
                        <img src="..<?php echo htmlspecialchars($image->url, ENT_QUOTES, 'UTF-8'); ?>" alt="Image du restaurant" style="float: <?php echo htmlspecialchars($image->position, ENT_QUOTES, 'UTF-8'); ?>;">
                    <?php endforeach; ?>
                <?php endif; ?>
                <h3>Carte des Plats</h3>
                <?php if (isset($restaurant->carte->plat)): ?>
                    <?php foreach ($restaurant->carte->plat as $plat): ?>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($plat->type, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Prix:</strong> <?php echo htmlspecialchars($plat->prix, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($plat->description, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <h3>Menus</h3>
                <?php if (isset($restaurant->menus->menu)): ?>
                    <?php foreach ($restaurant->menus->menu as $menu): ?>
                        <p><strong>Titre:</strong> <?php echo htmlspecialchars($menu->titre, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($menu->description, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Prix:</strong> <?php echo htmlspecialchars($menu->prix, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        <p>&copy; 2024 Portail Cinéma et Restaurants. Tous droits réservés.</p>
    </footer>
</body>
</html>
