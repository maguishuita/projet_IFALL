<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portail Web</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="homepage">
    <header>
        <h1>Bienvenue sur le Portail Cinéma et Restaurants</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="views/afficher_films.php">Voir les films</a></li>
                <li><a href="views/afficher_restaurants.php">Voir les restaurants</a></li>
                <li><a href="admin/login.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    <div class="carousel-container">
        <div class="carousel">
            <img src="d.jpg" alt="Image 1">
            <img src="b.jpg" alt="Image 2">
            <img src="c.jpg" alt="Image 3">
           
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>
    <footer>
        <p>&copy; 2024 Portail Cinéma et Restaurants. Tous droits réservés.</p>
    </footer>
    <script src="js/carousel.js"></script>
</body>
</html>
