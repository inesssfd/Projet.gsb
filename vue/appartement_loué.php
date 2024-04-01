<?php
session_start();
if (!isset($_SESSION['num_demandeur'])) {
    header("Location: ../index.php");
    exit;
}
include_once '../controleur/controleur_demandeurs.php';
include_once '../controleur/traitement_demande_location.php';
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;
$profil_demandeur = $demandeurs->getDemandeurById($num_demandeur_connecte);
$visites_prevues = getVisitesByDemandeur($num_demandeur_connecte);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <script src="../style/script.js" defer></script>
    <title>Visites du Demandeur</title>
</head>
<body class="cbody">

<nav>
    <ul>
        <li><a href="v_acceuil_demandeur.php">Accueil</a></li>
        <li><a href="appartement_loué.php">visite et profil du Demandeur</a></li>
        <div>Bienvenue, <?php echo (isset($_SESSION['login']) ? $_SESSION['login'] : 'Invité'); ?> | 
    Numéro du demandeur : <?php echo (isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : 'Invité'); ?> | 
    <a href="../modele/deconnexion.php">Déconnexion</a>
</div>
    </ul>
</nav>
<div id="profil" class="cbody">
    <h2>Profil du Demandeur</h2>
    <p>Nom : <span id="nom_demandeur" contenteditable="true"><?php echo $profil_demandeur['nom_demandeur']; ?></span></p>
    <p>Prénom : <span id="prenom_demandeur" contenteditable="true"><?php echo $profil_demandeur['prenom_demandeur']; ?></span></p>
    <p>Adresse : <span id="adresse_demandeur" contenteditable="true"><?php echo $profil_demandeur['adresse_demandeur']; ?></span></p>
    <p>Code postal : <span id="cp_demandeur" contenteditable="true"><?php echo $profil_demandeur['cp_demandeur']; ?></span></p>
    <p>Téléphone : <span id="tel_demandeur" contenteditable="true"><?php echo $profil_demandeur['tel_demandeur']; ?></span></p>
    <p>Login : <span id="login_demandeur" contenteditable="true"><?php echo $profil_demandeur['login']; ?></span></p>

    <button onclick="modifierDemandeur()">Modifier</button>
</div>

<div id="visites" class="cbody">
    <h2>Visites Prévues</h2>
    <?php
$count = 1; // Counter to add classes dynamically
foreach ($visites_prevues as $visite_prevue) {
    $apartmentClass = 'apartment' . $count; // Dynamic class name
    echo "<div class='visite $apartmentClass'>";
    echo "<p> Date de visite : " . $visite_prevue['date_visite'] . " Appartement : " . $visite_prevue['num_appt'] . "</p>";
   
    // Vérifier si la visite est une demande de location
    $demande = getDemandeByDemandeurAndAppt($_SESSION['num_demandeur'], $visite_prevue['num_appt']);

    if ($demande) {
        if ($demande['etat_demande'] !== 'Refusée') { // Vérifie si la demande n'est pas refusée
            // Si une demande existe et n'est pas refusée, afficher l'état de la demande et sa date
            echo "<p>Statut de la demande : " . $demande['etat_demande'] . "</p>";
            echo "<p>Date de la demande : " . $demande['date_demande'] . "</p>";
            if ($demande['etat_demande'] === 'En attente') {
                // Si l'état de la demande est "En attente", n'afficher pas le bouton "Devenir locataire"
                echo "<p>Vous avez une demande en attente pour cet appartement.</p>";
            } else {
                // Sinon, afficher l'état de la demande et sa date ainsi que le bouton "Devenir locataire"
                echo "<a class=\"link-button\" href=\"formulaire_location.php?num_appt=" . $visite_prevue['num_appt'] . "&num_demandeur=" . $num_demandeur_connecte . "\">Devenir locataire</a>";
            }
        } else {
            echo "<button onclick=\"supprimerDemande(" . $demande['id_demandes_location'] . ")\">Supprimer demande</button>";
            echo "<p>Statut de la demande : Refusée</p>";
            echo "<p>Cette demande a été refusée.</p>";
        }
    } else {
        // Si aucune demande n'existe, afficher les boutons "Modifier visite" et "Supprimer visite"
        echo "<button onclick=\"supprimerVisite(" . $visite_prevue['id_visite'] . ")\">Supprimer visite</button>";
        echo "<button onclick=\"modifierDate(" . $visite_prevue['id_visite'] . ", '" . $visite_prevue['date_visite'] . "')\">Modifier visite</button>";
        echo "<a class=\"link-button\" href=\"formulaire_demande.php?num_appt=" . $visite_prevue['num_appt'] . "&num_demandeur=" . $num_demandeur_connecte . "\">Faire une demande de location</a>";
    }
    
    echo "</div>";
    $count++;
}
?>

    
</div>
</body>
</html>
