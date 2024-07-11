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
    $titre = $_POST["titre"];
    $genre = $_POST["genre"];
    $duree = $_POST["duree"];
    $realisateur = $_POST["realisateur"];
    $langue = $_POST["langue"];
    $annee = $_POST["annee"];
    $synopsis = $_POST["synopsis"];
    $acteurs = explode(",", $_POST["acteurs"]);

    $films = simplexml_load_file('../xml/films.xml');
    if ($films === false) {
        echo "Failed to load XML file.";
        foreach(libxml_get_errors() as $error) {
            echo "<br>", $error->message;
        }
        exit;
    }

    $newFilm = $films->addChild('film');
    $newFilm->addChild('titre', $titre);
    $newFilm->addChild('genre', $genre);
    $newFilm->addChild('duree', $duree);
    $newFilm->addChild('realisateur', $realisateur);
    $newFilm->addChild('langue', $langue);
    $newFilm->addChild('annee', $annee);
    $newFilm->addChild('synopsis', $synopsis);
    $acteursElement = $newFilm->addChild('acteurs');
    foreach ($acteurs as $acteur) {
        $acteursElement->addChild('acteur', trim($acteur));
    }

    $result = $films->asXML('../xml/films.xml');
    if ($result) {
        echo "Film ajouté avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Film</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Ajouter un Film</h1>
    <form action="ajouter_film.php" method="post">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required><br>
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required><br>
        <label for="duree">Durée:</label>
        <input type="text" id="duree" name="duree" required><br>
        <label for="realisateur">Réalisateur:</label>
        <input type="text" id="realisateur" name="realisateur" required><br>
        <label for="langue">Langue:</label>
        <input type="text" id="langue" name="langue" required><br>
        <label for="annee">Année:</label>
        <input type="text" id="annee" name="annee" required><br>
        <label for="synopsis">Synopsis:</label>
        <textarea id="synopsis" name="synopsis" required></textarea><br>
        <label for="acteurs">Acteurs (séparés par des virgules):</label>
        <input type="text" id="acteurs" name="acteurs" required><br>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
