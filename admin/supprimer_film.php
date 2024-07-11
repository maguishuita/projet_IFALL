<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    unset($films->film[$id]);
    $result = $films->asXML('../xml/films.xml');
    if ($result) {
        echo "Film supprimé avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un Film</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Supprimer un Film</h1>
    <form action="supprimer_film.php" method="post">
        <label for="id">Sélectionner un film à supprimer:</label>
        <select id="id" name="id">
            <option value="">--Sélectionner--</option>
            <?php foreach ($films->film as $index => $film): ?>
                <option value="<?php echo $index; ?>">
                    <?php echo $film->titre; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Supprimer">
    </form>
</body>
</html>
