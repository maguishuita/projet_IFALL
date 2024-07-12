<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Administrateur</h1>
     
   
    <div class="admin-container">
        <div class="admin-buttons">
        <button >
        <a href="../index.php">Retour au site</a>
        </button>
            <button onclick="toggleDropdown('films-dropdown')">Films</button>
            <div id="films-dropdown" class="dropdown-content">
                <a href="ajouter_film.php">Ajouter un film</a>
                <a href="modifier_film.php">Modifier un film</a>
                <a href="supprimer_film.php">Supprimer un film</a>
            </div>

            <button onclick="toggleDropdown('restaurants-dropdown')">Restaurants</button>
            <div id="restaurants-dropdown" class="dropdown-content">
                <a href="ajouter_fiche_restaurant.php">Ajouter un restaurant</a>
                <a href="modifier_fiche_restaurant.php">Modifier un restaurant</a>
                <a href="supprimer_fiche_restaurant.php">Supprimer un restaurant</a>
            </div>
            
            <a href="logout.php"><button>Se déconnecter</button></a>
        </div>
    </div>
    </header>
    <footer>
        <p>&copy; 2024 Administrateur Portail Cinéma et Restaurants. Tous droits réservés.</p>
    </footer>

    <script>
        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('button')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
    
</body>
</html>
