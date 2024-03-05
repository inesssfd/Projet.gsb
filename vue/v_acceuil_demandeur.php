<?php

include_once '../modele/modele_app.php';
include_once '../controleur/controleur_app.php';
include_once '../controleur/controleur_visite.php';

// Récupérer la liste des appartements
$appartements = Appartement::getAllAppartements();
$appartements_demandeur = AppartementController::rechercherAppartements();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<nav>
    <ul>
        <li><a href="v_acceuil_demandeur.php">Accueil</a></li>
        <li><a href="appartement_loué.php">visites et profil du Demandeur</a></li>
        <div>Bienvenue, <?php echo (isset($_SESSION['login']) ? $_SESSION['login'] : 'Invité'); ?> (Numéro Demandeur: <?php echo isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : 'N/A'; ?>) | <a href="../modele/deconnexion.php">Déconnexion</a></div>

        <li>
            <form method="GET" action="v_acceuil_demandeur.php" id="search-form">
                <label for="type_appt">Type :</label>
                <input type="text" name="type_appt" id="type_appt">

                <label for="arrondisement">Arrondissement :</label>
                <input type="text" name="arrondisement" id="arrondisement">

                <label for="prix_loc">Prix maximum :</label>
                <input type="text" name="prix_loc" id="prix_loc">

                <input type="submit" value="Rechercher">
            </form>
        </li>
    </ul>
</nav>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_acceuil.css">
    <script src="../style/script.js" defer></script>
    <link rel="stylesheet" href="../style/style_appartement.css">
</head>
<body>
    
<div>
    <?php
    echo '<div class="appartements-container" >';
    echo "<h2>Liste des Appartements</h2>";
    $num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;
    echo "Numéro du demandeur connecté : " . $num_demandeur_connecte;
    // Counter for controlling the layout
    $apartments_in_row = 0;

    foreach ($appartements_demandeur as $appartement) {
        // Start a new row after every 3 apartments
        if ($apartments_in_row % 3 === 0) {
            echo '<div class="row" style="display: flex; justify-content: space-between; margin-bottom: 20px;">';
        }
        echo '<div class="appartement-proprio" style="max-width: 60%;">';
        echo "<strong>Type :</strong> " . $appartement['type_appt'] . "<br>";
        echo "<strong>Prix :</strong> " . $appartement['prix_loc'] . "<br>";
        echo "<strong>Charges :</strong> " . $appartement['prix_charge'] . "<br>";
        echo "<strong>Rue :</strong> " . $appartement['rue'] . "<br>";
        echo "<strong>Arrondissement :</strong> " . $appartement['arrondisement'] . "<br>";
        echo "<strong>Étage :</strong> " . $appartement['etage'] . "<br>";
        echo "<strong>Ascenseur :</strong> " . $appartement['ascenceur'] . "<br>";
        echo "<strong>Préavis :</strong> " . $appartement['preavis'] . "<br>";
        echo "<strong>Date libre :</strong> " . $appartement['date_libre'] . "<br>";
        echo "<strong>Numéro Propriétaire :</strong> " . $appartement['numero_prop'] . "<br>";
        echo '<input type="hidden" name="num_appt" value="' . $appartement['num_appt'] . '">';
        echo '<button class="visit-button" onclick=\'console.log("Visiter button clicked"); showVisitForm(' . $appartement['num_appt'] . ',' . $num_demandeur_connecte . ')\'>Visiter</button></p>';
        echo "</div>";

        // End the row after every 3 apartments
        if ($apartments_in_row % 3 === 2 || $apartments_in_row === count($appartements_demandeur) - 1) {
            echo '</div>';
        }

        $apartments_in_row++;
    }

    echo "</div>";
    ?>
</div>
<div id="myModal" class="modal">
    <!-- Contenu de la modalité -->
    <div class="modal-content">
        <!-- Bouton de fermeture -->
        <span class="close" onclick="closeModal()">&times;</span>
        
        <!-- Contenu du formulaire -->
        <div id="visitFormContainer"></div>
    </div>
</div>

</body>
</html>