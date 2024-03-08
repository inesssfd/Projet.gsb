<?php
session_start();

// Inclure la classe Visite ici (assurez-vous que le chemin est correct)
include_once '../modele/modele_visite.php';
include_once '../modele/modele_demandeur.php';
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
        echo "<p> Date de visite : <span id='date_visite_" . $visite_prevue['id_visite'] . "'>" . $visite_prevue['date_visite'] . "</span>";
        echo " Appartement : " . $visite_prevue['num_appt'] . "</p>";
        echo "<button onclick=\"modifierDate(" . $visite_prevue['id_visite'] . ")\">Modifier</button>";
    
        // Ajouter le bouton "Loué" avec un appel à la fonction louerLocataire
        echo "<button onclick=\"louerLocataire(" . $visite_prevue['num_appt'] . ")\">Louer</button>";
    
        // Ajouter le bouton "Supprimer" avec un appel à la fonction supprimerVisite
        echo "<button onclick=\"supprimerVisite(" . $visite_prevue['id_visite'] . ")\">Supprimer</button>";
    
        echo "</div>";
        $count++;
    }
    ?>
</div>
</body>
</html>
