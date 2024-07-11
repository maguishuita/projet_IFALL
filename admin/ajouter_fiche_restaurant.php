<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $adresse = $_POST["adresse"];
    $nomRestaurateur = $_POST["nomRestaurateur"];
    $description = $_POST["description"];
    $images = explode(",", $_POST["images"]);

    $restaurants = simplexml_load_file('../xml/restaurants.xml');
    if ($restaurants === false) {
        echo "Failed to load XML file.";
        foreach(libxml_get_errors() as $error) {
            echo "<br>", $error->message;
        }
        exit;
    }

    $newRestaurant = $restaurants->addChild('restaurant');
    $coordonnees = $newRestaurant->addChild('coordonnees');
    $coordonnees->addChild('nom', $nom);
    $coordonnees->addChild('adresse', $adresse);
    $coordonnees->addChild('nomRestaurateur', $nomRestaurateur);
    $coordonnees->addChild('description', $description);
    $imagesElement = $coordonnees->addChild('images');
    foreach ($images as $image) {
        $img = $imagesElement->addChild('image');
        $img->addChild('url', trim($image));
        $img->addChild('position', 'centre'); // Exemple de position
    }

    $result = $restaurants->asXML('../xml/restaurants.xml');
    if ($result) {
        echo "Fiche de restaurant ajoutée avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Fiche de Restaurant</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Ajouter une Fiche de Restaurant</h1>
    <form action="ajouter_fiche_restaurant.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" required><br>
        <label for="nomRestaurateur">Nom du Restaurateur:</label>
        <input type="text" id="nomRestaurateur" name="nomRestaurateur" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        <label for="images">Images (URLs séparées par des virgules):</label>
        <input type="text" id="images" name="images" required><br>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
