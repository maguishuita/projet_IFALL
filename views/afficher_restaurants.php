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
    <title>Fiches de Restaurants</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Fiches de Restaurants</h1>
    <?php foreach ($restaurants->restaurant as $restaurant): ?>
        <h2><?php echo $restaurant->coordonnees->nom; ?></h2>
        <p><strong>Adresse:</strong> <?php echo $restaurant->coordonnees->adresse; ?></p>
        <p><strong>Nom du Restaurateur:</strong> <?php echo $restaurant->coordonnees->nomRestaurateur; ?></p>
        <p><strong>Description:</strong> <?php echo $restaurant->coordonnees->description; ?></p>
        <?php if (isset($restaurant->coordonnees->images)): ?>
            <h3>Images</h3>
            <?php foreach ($restaurant->coordonnees->images->image as $image): ?>
                <img src="<?php echo $image->url; ?>" alt="Image du restaurant" style="float: <?php echo $image->position; ?>;">
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($restaurant->carte->plat)): ?>
            <h3>Carte des Plats</h3>
            <?php foreach ($restaurant->carte->plat as $plat): ?>
                <p><strong>Type:</strong> <?php echo $plat->type; ?></p>
                <p><strong>Prix:</strong> <?php echo $plat->prix; ?></p>
                <p><strong>Description:</strong> <?php echo $plat->description; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($restaurant->menus->menu)): ?>
            <h3>Menus</h3>
            <?php foreach ($restaurant->menus->menu as $menu): ?>
                <p><strong>Titre:</strong> <?php echo $menu->titre; ?></p>
                <p><strong>Description:</strong> <?php echo $menu->description; ?></p>
                <p><strong>Prix:</strong> <?php echo $menu->prix; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>
