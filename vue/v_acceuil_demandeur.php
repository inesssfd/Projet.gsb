<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['num_demandeur']) && !isset($_SESSION['numero_prop'])) {
    header("Location: ../index.php");
    exit;
}
// Récupérer le numéro du demandeur connecté depuis la session
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;


include_once '../controleur/controleur_app.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <script src="../style/script.js" defer></script>
</head>
<body>
    
<nav>
    <ul>
    <li><a href="v_acceuil_demandeur.php"><img src="../style/loger.png" alt="Accueil" style="width: 30px; height: 30px;"></a></li>
    <li><a href="appartement_loué.php?num_demandeur=<?php echo $num_demandeur_connecte; ?>"><img src="../style/profil.png" alt="Profil" style="width: 30px; height: 30px;"></a></li>


        <div>Bienvenue, <?php echo (isset($_SESSION['num_demandeur']) ? $_SESSION['login'] : 'Invité'); ?> (Numéro Demandeur: <?php echo isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : 'N/A'; ?>) | <a href="../modele/deconnexion.php">Déconnexion</a></div>

        <li>
        <form method="GET" action="v_acceuil_demandeur.php" class="search-form">
    <label class="search-form" for="type_appt">Type :</label>
    <select name="type_appt" id="type_appt" class="search-form">
        <option value="">Tous</option>
        <option value="Studio">Studio</option>
        <option value="T1">T1</option>
        <option value="T2">T2</option>
        <option value="T3">T3</option>
        <option value="T4">T4</option>
        <option value="T5">T5</option>
    </select>

    <label  class="search-form" for="arrondisement">Arrondissement :</label>
    <select  class="search-form" name="arrondisement" id="arrondisement">
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
    <input type="text" name="prix_loc" id="prix_loc" class="search-form">
    <input type="hidden" name="action" value="rechercherAppartements">
    <input type="image" src="../style/loupe.png" alt="Rechercher" class="search-button" style="width: 20px; height: 20px;">



</form>
        </li>
    </ul>
</nav>

<div>
    <?php
    echo '<div class="appartements-container">';
    echo "<h2>Liste des Appartements</h2>";
    $num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;
    $apartments_in_row = 0;

    // Début du bloc foreach pour afficher les résultats des appartements
    foreach ($appartements as $appartement) {

        // Vérification des critères de recherche
        if ((!isset($type_appt) || $type_appt == "" || $type_appt == $appartement->getTypeAppt()) &&
            (!isset($arrondisement) || $arrondisement == "" || $arrondisement == $appartement->getArrondisement()) &&
            (!isset($prix_loc) || $prix_loc == "" || $prix_loc >= $appartement->getPrixLoc())) {

            // Commencez une nouvelle ligne après chaque 3 appartements
            if ($apartments_in_row % 3 === 0) {
                echo '<div class="row" style="display: flex; justify-content: space-between; margin-bottom: 20px;">';
            }
            echo '<div class="appartement-proprio" style="max-width: 60%;">';
            // Affichage des détails de l'appartement
            echo "<strong>Type :</strong> " . $appartement->getTypeAppt() . "<br>";
            echo "<strong>Prix :</strong> " . $appartement->getPrixLoc() . "<br>";
            echo "<strong>Charges :</strong> " . $appartement->getPrixCharge() . "<br>";
            echo "<strong>Rue :</strong> " . $appartement->getRue() . "<br>";
            echo "<strong>Arrondissement :</strong> " . $appartement->getArrondisement() . "<br>";
            echo "<strong>Étage :</strong> " . $appartement->getEtage() . "<br>";
            echo "<strong>Ascenseur :</strong> " . $appartement->getAscenceur() . "<br>";
            echo "<strong>Préavis :</strong> " . $appartement->getPreavis() . "<br>";
            echo "<strong>Date libre :</strong> " . $appartement->getDateLibre() . "<br>";
            echo "<strong>Numéro Propriétaire :</strong> " . $appartement->getNumeroProp() . "<br>";        
            echo '<input type="hidden" name="num_appt" value="' . $appartement->getNumAppt() . '">';
            echo '<button class="visit-button" onclick=\'console.log("Visiter button clicked"); showVisitForm(' . $appartement->getNumAppt() . ',' . $num_demandeur_connecte . ')\'>Visiter</button></p>';
            echo "</div>";

            // Terminer la ligne après chaque 3 appartements
            if ($apartments_in_row % 3 === 2 || $apartments_in_row === count($appartements) - 1) {
                echo '</div>';
            }

            $apartments_in_row++;
        }
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
