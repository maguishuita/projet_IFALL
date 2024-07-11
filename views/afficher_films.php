<?php
$films = simplexml_load_file('../xml/films.xml');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affiches de Cinéma</title>
    <link rel="stylesheet" href="/projet_IFALL/css/styles.css">
</head>
<body>
    <h1>Affiches de Cinéma</h1>
    <?php foreach ($films->film as $film): ?>
        <h2><?php echo $film->titre; ?></h2>
        <p><strong>Genre:</strong> <?php echo $film->genre; ?></p>
        <p><strong>Durée:</strong> <?php echo $film->duree; ?></p>
        <p><strong>Réalisateur:</strong> <?php echo $film->realisateur; ?></p>
        <p><strong>Langue:</strong> <?php echo $film->langue; ?></p>
        <p><strong>Acteurs:</strong> <?php echo implode(', ', (array)$film->acteurs->acteur); ?></p>
        <p><strong>Année:</strong> <?php echo $film->annee; ?></p>
        <?php if (isset($film->notes)): ?>
            <p><strong>Notes Presse:</strong> <?php echo $film->notes->presse; ?></p>
            <p><strong>Notes Spectateurs:</strong> <?php echo $film->notes->spectateurs; ?></p>
        <?php endif; ?>
        <p><strong>Synopsis:</strong> <?php echo $film->synopsis; ?></p>
        <p><strong>Horaires:</strong> <?php echo implode(' | ', (array)$film->horaires->horaire); ?></p>
    <?php endforeach; ?>
</body>
</html>
