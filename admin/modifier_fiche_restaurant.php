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
    $id = $_POST['id'];
    $restaurant = $restaurants->restaurant[intval($id)];
    $restaurant->coordonnees->nom = $_POST["nom"];
    $restaurant->coordonnees->adresse = $_POST["adresse"];
    $restaurant->coordonnees->nomRestaurateur = $_POST["nomRestaurateur"];
    $restaurant->coordonnees->description = $_POST["description"];
    $restaurant->coordonnees->images = '';
    $images = explode(",", $_POST["images"]);
    foreach ($images as $image) {
        $img = $restaurant->coordonnees->images->addChild('image');
        $img->addChild('url', trim($image));
        $img->addChild('position', 'centre'); // Exemple de position
    }

    $result = $restaurants->asXML('../xml/restaurants.xml');
    if ($result) {
        echo "Fiche de restaurant modifiée avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Fiche de Restaurant</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Modifier une Fiche de Restaurant</h1>
    <form action="modifier_fiche_restaurant.php" method="post">
        <label for="id">Sélectionner un restaurant:</label>
        <select id="id" name="id" onchange="this.form.submit()">
            <option value="">--Sélectionner--</option>
            <?php foreach ($restaurants->restaurant as $index => $restaurant): ?>
                <option value="<?php echo $index; ?>" <?php if (isset($_POST['id']) && $_POST['id'] == $index) echo 'selected'; ?>>
                    <?php echo $restaurant->coordonnees->nom; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (isset($_POST['id'])): ?>
        <?php $restaurant = $restaurants->restaurant[intval($_POST['id'])]; ?>
        <form action="modifier_fiche_restaurant.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo $restaurant->coordonnees->nom; ?>" required><br>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo $restaurant->coordonnees->adresse; ?>" required><br>
            <label for="nomRestaurateur">Nom du Restaurateur:</label>
            <input type="text" id="nomRestaurateur" name="nomRestaurateur" value="<?php echo $restaurant->coordonnees->nomRestaurateur; ?>" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $restaurant->coordonnees->description; ?></textarea><br>
            <label for="images">Images (URLs séparées par des virgules):</label>
            <input type="text" id="images" name="images" value="<?php echo implode(", ", (array)$restaurant->coordonnees->images->image); ?>" required><br>
            <input type="submit" value="Modifier">
        </form>
    <?php endif; ?>
</body>
</html>
