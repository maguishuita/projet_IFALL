<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$restaurants = simplexml_load_file('../xml/restaurants.xml');
if ($restaurants === false) {
    echo "Failed to load XML file.";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    unset($restaurants->restaurant[$id]);
    $result = $restaurants->asXML('../xml/restaurants.xml');
    if ($result) {
        echo "Fiche de restaurant supprimée avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer une Fiche de Restaurant</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Supprimer une Fiche de Restaurant</h1>
    <form action="supprimer_fiche_restaurant.php" method="post">
        <label for="id">Sélectionner une fiche de restaurant à supprimer:</label>
        <select id="id" name="id">
            <option value="">--Sélectionner--</option>
            <?php foreach ($restaurants->restaurant as $index => $restaurant): ?>
                <option value="<?php echo $index; ?>">
                    <?php echo $restaurant->coordonnees->nom; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Supprimer">
    </form>
</body>
</html>
