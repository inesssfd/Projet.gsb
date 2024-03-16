<?php
session_start();
if (!isset($_SESSION['num_demandeur']) && !isset($_SESSION['numero_prop'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}

// Inclure la classe Visite ici (assurez-vous que le chemin est correct)
include_once '../modele/modele_visite.php';
include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_demande.php';

// Récupérer le numéro du demandeur connecté depuis la session
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

// Récupérer le profil du demandeur connecté
$profil_demandeur = (new demandeurs())->getDemandeurById($num_demandeur_connecte);

// Récupérer les visites prévues par le demandeur connecté
$visites_prevues = (new Visite())->getVisitesByDemandeur($num_demandeur_connecte);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <script> function supprimerVisite(id_visite) {
        // Envoyer la demande de suppression au serveur en utilisant AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // La suppression a réussi côté serveur, supprimez l'élément côté client
                var visiteElement = document.getElementById('date_visite_' + id_visite).closest('.visite');
                visiteElement.parentNode.removeChild(visiteElement);
            }
        };

        // Envoyer la requête POST vers le fichier PHP côté serveur (class_visite.php dans ce cas)
        xhr.open('POST', '../controleur/controleur_visite.php?action=deleteVisit"', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('id_visite=' + id_visite + '&action=deleteVisit');
    }</script>
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
    $demande = Demande::getDemandeByDemandeurAndAppt($_SESSION['num_demandeur'], $visite_prevue['num_appt']);

    if ($demande) {
        // Si une demande existe, afficher l'état de la demande et sa date
        echo "<p>Statut de la demande : " . $demande['etat_demande'] . "</p>";
        echo "<p>Date de la demande : " . $demande['date_demande'] . "</p>";
        echo "<a href=\"formulaire_location.php?num_appt=" . $visite_prevue['num_appt'] . "&num_demandeur=" . $num_demandeur_connecte . "\">Devenir locataire</a>";
    } else {
        // Si aucune demande n'existe, afficher les boutons "Modifier visite" et "Supprimer visite"
        echo "<button onclick=\"modifierDate(" . $visite_prevue['id_visite'] . ")\">Modifier visite</button>";
        echo "<button onclick=\"supprimerVisite(" . $visite_prevue['id_visite'] . ")\">Supprimer visite</button>";
        // Afficher le lien "Faire une demande de location" vers le formulaire de demande
        echo "<a href=\"formulaire_demande.php?num_appt=" . $visite_prevue['num_appt'] . "&num_demandeur=" . $num_demandeur_connecte . "\">Faire une demande de location</a>";
    }
    
    echo "</div>";
    $count++;
}

    
    
    ?>
    
    
</div>
</body>
</html>
