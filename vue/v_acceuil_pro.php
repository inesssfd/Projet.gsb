<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../controleur/controleur_proprietaire.php'; // Inclure le fichier avec la définition de la fonction
if (isset($_SESSION['numero_prop'])) {
    $numero_prop = $_SESSION['numero_prop'];
} else {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Appartements</title>
    <script src="../style/script.js" defer></script>
    <script src="../style/appartement.js" defer></script>
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

    <?php
    // Vérifie si des appartements sont disponibles
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
            echo "<img src='../style/poubelle.png' alt='Supprimer' class='custom-pro' onclick='supprimerAppartement(" . $appartement['num_appt'] . ")' style='width: 50px; height: 50px;'>";
            echo "<img src='../style/modifier-le-fichier.png' alt='Modifier' class='custom-pro' onclick='modifierAppartement(" . $appartement['num_appt'] . ", " . $_SESSION['numero_prop'] . ")'style='width: 50px; height: 50px;'>";
            echo "</div>";  // Fermer la div pour le conteneur de boutons ici
            echo "</ul>";  // Fermer la liste interne ici
    
            // Afficher l
            if (isset($demandes_par_appartement[$appartement['num_appt']]) && !empty($demandes_par_appartement[$appartement['num_appt']])) {
                echo "<div class='demandes-container'>";
                echo "<h3>Demandes pour l'appartement " . $appartement['num_appt'] . "</h3>";
                echo "<ul>";
                // Boucle à travers les demandes
                foreach ($demandes_par_appartement[$appartement['num_appt']] as $demande) {
                    echo "<li>";
                    echo "<p>Date de la demande : " . $demande['date_demande'] . "</p>";
                    echo "<p>Statut : " . $demande['etat_demande'] . "</p>";
                    echo "<p>Numéro de Demandeur : " . $demande['num_demandeur'] . "</p>";
                    echo "<button onclick='modifierEtatDemande(" . $demande['id_demandes_location'] . ", \"Acceptée\")'>Accepter</button>";
                    echo "<button onclick='modifierEtatDemande(" . $demande['id_demandes_location'] . ", \"Refusée\")'>Refuser</button>";
                    echo "</li>";                
                }
                echo "</ul>";
                echo "</div>";
            } else {
                echo "<p>Aucune demande pour l'appartement " . $appartement['num_appt'] . "</p>";
            }
    
            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<p>Vous n'avez pas encore ajouté d'appartements.</p>";
    }
    ?>
</body>

</html>
