<?php

include_once '../modele/modele_app.php';
include_once '../controleur/controleur_app.php';
include_once '../controleur/controleur_visite.php';

// Récupérer la liste des appartements
$appartements = Appartement::getAllAppartements();
$controller = new AppartementController();

// Call the rechercherAppartements() method on the instance
$appartements_demandeur = Appartement::getAppartementsSansLocataire();

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
    <select name="type_appt" id="type_appt">
        <option value="">Tous</option>
        <option value="Studio">Studio</option>
        <option value="T1">T1</option>
        <option value="T2">T2</option>
        <option value="T3">T3</option>
        <option value="T4">T4</option>
        <option value="T5">T5</option>
    </select>

    <label for="arrondisement">Arrondissement :</label>
    <select name="arrondisement" id="arrondisement">
        <option value="">Tous</option>
        <?php
        // Tableau des arrondissements de Paris avec les codes postaux
        $arrondissements_paris = array(
            "75001" => "1er", 
            "75002" => "2e", 
            "75003" => "3e", 
            "75004" => "4e", 
            "75005" => "5e", 
            "75006" => "6e", 
            "75007" => "7e", 
            "75008" => "8e", 
            "75009" => "9e", 
            "75010" => "10e",
            "75011" => "11e", 
            "75012" => "12e", 
            "75013" => "13e", 
            "75014" => "14e", 
            "75015" => "15e", 
            "75016" => "16e", 
            "75017" => "17e", 
            "75018" => "18e", 
            "75019" => "19e", 
            "75020" => "20e"
        );

        // Boucle pour générer les options de la liste déroulante
        foreach ($arrondissements_paris as $code_postal => $arrondissement) {
            echo "<option value=\"$code_postal\">$code_postal - $arrondissement</option>";
        }
        ?>
    </select>

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