<?php
session_start();
include_once '../modele/modele_app.php';

// Check if the owner is logged in
if (isset($_SESSION['numero_prop'])) {
    $numero_prop = $_SESSION['numero_prop'];

    // Fetch apartments for the logged-in owner
    $appartements = Appartement::getAllAppartementsByProprietaire($numero_prop);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../style/script.js" defer></script>
    <link rel="stylesheet" href="../style/style_appartement.css">

</head>

<body>
    <header>
        <div id="company-title">
            <h1>HomeHarmony</h1>
        </div>
        <h2>Bienvenue, propriétaires! Gérez vos biens en toute simplicité.</h2>
        <nav>
            <ul>
                <li><a href="profil_proprietaire.php">Profil</a></li>
                <li><a href="ajouter_logement.php">Ajouter un Logement</a></li>
                <div>Bienvenue, <?php echo (isset($_SESSION['login_prop']) ? $_SESSION['login_prop'] : 'Invité'); ?> | <span>Propriétaire ID: <?php echo (isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : 'N/A'); ?></span> | <a href="../modele/deconnexion.php">Déconnexion</a></div>
            </ul>
        </nav>
    </header>

    <!-- Le reste du contenu de la page va ici -->

    <?php
    
// Check if there are apartments to display
if (isset($appartements) && !empty($appartements)) {
    echo '<div class="appartements-container">';
    echo "<h2>Vos Appartements</h2>";
    echo "<ul>";
    foreach ($appartements as $appartement) {
        echo "<li class='" . ($appartement['numero_prop'] == $_SESSION['numero_prop'] ? 'appartement-proprio' : 'appartement') . "' style='max-width: 600px; margin-bottom: 20px;'>";
        echo "<strong>Appartement " . $appartement['num_appt'] . " :</strong>";
        echo "<ul>";  // Ouvrir une nouvelle liste ici
        echo "<li><strong>type_appt:</strong> <span id='type_appt_" . $appartement['num_appt'] . "' contenteditable='true'>" . $appartement['type_appt'] . "</span></li>";
        echo "<li><strong>prix_loc:</strong> <span id='prix_loc_" . $appartement['num_appt'] . "' contenteditable='true'>" . $appartement['prix_loc'] . "</span></li>";
        echo "<li><strong>prix_charge:</strong> <span id='prix_charge_" . $appartement['num_appt'] . "' contenteditable='true'>" . $appartement['prix_charge'] . "</span></li>";
        echo "<li><strong>rue :</strong> <span id='rue_" . $appartement['num_appt'] . "' contenteditable='true'>" . $appartement['rue'] . "</span></li>";        
        echo "<div class='button-container'>";
        echo "<button class='custom-pro' onclick='supprimerAppartement(" . $appartement['num_appt'] . ")'>Supprimer</button>";
        echo "<button class='custom-pro' onclick='modifierAppartement(" . $appartement['num_appt'] . ", " . $_SESSION['numero_prop'] . ")'>Modifier</button>";
        echo "</div>";  // Fermer la div pour le conteneur de boutons ici
        echo "</ul>";  // Fermer la liste interne ici
        echo "</li>";
    }
    echo "</ul>";  // Fermer la liste externe ici
    echo "</div>";
} else {
    echo "<p>Vous n'avez pas encore ajouté d'appartements.</p>";
}


?>
</body>

</html>
