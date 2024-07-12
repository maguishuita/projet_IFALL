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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['titre']) && isset($_POST['genre']) && isset($_POST['duree']) && isset($_POST['realisateur']) && isset($_POST['langue']) && isset($_POST['annee']) && isset($_POST['synopsis']) && isset($_POST['acteurs'])) {
    $id = $_POST['id'];
    $film = $films->film[intval($id)];
    $film->titre = $_POST["titre"];
    $film->genre = $_POST["genre"];
    $film->duree = $_POST["duree"];
    $film->realisateur = $_POST["realisateur"];
    $film->langue = $_POST["langue"];
    $film->annee = $_POST["annee"];
    $film->synopsis = $_POST["synopsis"];
    $film->acteurs = '';
    $acteurs = explode(",", $_POST["acteurs"]);
    foreach ($acteurs as $acteur) {
        $film->acteurs->addChild('acteur', trim($acteur));
    }

    $result = $films->asXML('../xml/films.xml');
    if ($result) {
        echo "Film modifié avec succès !";
    } else {
        echo "Failed to save the XML file.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Film</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Modifier un Film</h1>
    <form action="modifier_film.php" method="post">
        <label for="id">Sélectionner un film:</label>
        <select id="id" name="id" onchange="this.form.submit()">
            <option value="">--Sélectionner--</option>
            <?php foreach ($films->film as $index => $film): ?>
                <option value="<?php echo $index; ?>" <?php if (isset($_POST['id']) && $_POST['id'] == $index) echo 'selected'; ?>>
                    <?php echo $film->titre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (isset($_POST['id'])): ?>
        <?php $film = $films->film[intval($_POST['id'])]; ?>
        <form action="modifier_film.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($film->titre, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($film->genre, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="duree">Durée:</label>
            <input type="text" id="duree" name="duree" value="<?php echo htmlspecialchars($film->duree, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="realisateur">Réalisateur:</label>
            <input type="text" id="realisateur" name="realisateur" value="<?php echo htmlspecialchars($film->realisateur, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="langue">Langue:</label>
            <input type="text" id="langue" name="langue" value="<?php echo htmlspecialchars($film->langue, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="annee">Année:</label>
            <input type="text" id="annee" name="annee" value="<?php echo htmlspecialchars($film->annee, ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <label for="synopsis">Synopsis:</label>
            <textarea id="synopsis" name="synopsis" required><?php echo htmlspecialchars($film->synopsis, ENT_QUOTES, 'UTF-8'); ?></textarea><br>
            <label for="acteurs">Acteurs (séparés par des virgules):</label>
            <input type="text" id="acteurs" name="acteurs" value="<?php echo htmlspecialchars(implode(", ", (array)$film->acteurs->acteur), ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <input type="submit" value="Modifier">
        </form>
    <?php endif; ?>
</body>
</html>
