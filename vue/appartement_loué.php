<?php
session_start();
if (!isset($_SESSION['num_demandeur']) && !isset($_SESSION['numero_prop'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
include_once '../controleur/controleur_visite.php';
include_once '../controleur/affichage_demande.php';
// Récupérer le numéro du demandeur connecté depuis la session
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

// Récupérer le profil du demandeur connecté
$profil_demandeur = (new demandeurs())->getDemandeurById($num_demandeur_connecte);

// Récupérer les visites prévues par le demandeur connecté

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
    Numéro du demandeur : <?php echo ((isset($_SESSION['num_demandeur']) && $_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : 'Invité'); ?> | 
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

<h1>Visites et demandes du demandeur</h1>
<?php if ($visites || $demandes): ?>
    <?php foreach ($visites as $visite): ?>
        <div class="visite">
            <p>ID Visite: <?php echo $visite['id_visite']; ?></p>
            <p>Appartement: <?php echo $visite['num_appt']; ?></p>
            <p>Date: <?php echo $visite['date_visite']; ?></p>
            <button onclick="supprimerVisite(<?php echo $visite['id_visite']; ?>)">Supprimer visite</button>
            <button onclick="modifierDate(<?php echo $visite['id_visite']; ?>, '<?php echo $visite['date_visite']; ?>')">Modifier visite</button>
            <a class="link-button" href="formulaire_demande.php?num_appt=<?php echo $visite['num_appt']; ?>&num_demandeur=<?php echo $num_demandeur_connecte; ?>">Faire une demande de location</a>

        </div>
    <?php endforeach; ?>
    <?php foreach ($demandes as $demande): ?>
        <div class="visite">
            <p>ID Demande: <?php echo $demande['id_demandes_location']; ?></p>
            <p>Appartement: <?php echo $demande['num_appt']; ?></p>
            <p>Date de la demande: <?php echo $demande['date_demande']; ?></p>
            <!-- Afficher l'état de la demande -->
            <?php if ($demande['etat_demande'] == 'En attente'): ?>
                <p>État de la demande: En attente (<?php echo $demande['date_demande']; ?>)</p>
            <?php elseif ($demande['etat_demande'] == 'Acceptée'): ?>
                <p>État de la demande: Acceptée</p>
                <a class="link-button" href="formulaire_location.php?num_appt=<?php echo $demande['num_appt']; ?>&num_demandeur=<?php echo $num_demandeur_connecte; ?>">Devenir locataire</a>
            <?php elseif ($demande['etat_demande'] == 'Refusée'): ?>
                <p>État de la demande: Refusée</p>
                <button onclick="supprimerDemande(<?php echo $demande['id_demandes_location']; ?>)">Supprimer la demande</button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune visite ou demande trouvée pour le demandeur avec le numéro : <?php echo $num_demandeur_connecte; ?></p>
<?php endif; ?>



</div>

</body>
</html>
