<?php
session_start();

include_once '..\modele\modele_loc.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
$locataire = new Locataire();
$num_loc = $_SESSION['user_id'];
$detailsLocataire = $locataire->getDetailslocataireById($num_loc);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">

    <script src="../style/script.js" defer></script>
    <title>Profil du Locataire</title>
</head>
<body>

<nav>
    <ul>
        <li><a href="v_accueil_loc.php">Accueil</a></li>
        <li><a href="profil_loccataire.php">Profil du locataire</a></li>
        
        <div>
            Bienvenue,
            <?php
            echo $_SESSION['login_loc'];
            ?>
            | <a href="../modele/deconnexion.php">Déconnexion</a>
        </div>
    </ul>
</nav>

<div id="profil" class="cbody">
        <h2>Profil du Locataire</h2>
        <p>Nom: <span id="nom_loc" contenteditable="true"><?php echo $detailsLocataire['nom_loc']; ?></span></p>
        <p>Prénom: <span id="prenom_loc" contenteditable="true"><?php echo $detailsLocataire['prenom_loc']; ?></span></p>
        <p>Date de Naissance: <span id="date_nais" contenteditable="true"><?php echo $detailsLocataire['date_nais']; ?></span></p>
        <p>Téléphone: <span id="tel_loc" contenteditable="true"><?php echo $detailsLocataire['tel_loc']; ?></span></p>
        <p>Numéro Bancaire: <span id="num_bancaire" contenteditable="true"><?php echo $detailsLocataire['num_bancaire']; ?></span></p>
        <p>Nom de la Banque: <span id="nom_banque" contenteditable="true"><?php echo $detailsLocataire['nom_banque']; ?></span></p>
        <p>Code Postal de la Banque: <span id="cp_banque" contenteditable="true"><?php echo $detailsLocataire['cp_banque']; ?></span></p>
        <p>Téléphone de la Banque: <span id="tel_banque" contenteditable="true"><?php echo $detailsLocataire['tel_banque']; ?></span></p>
        <!-- Ajoutez d'autres informations du locataire selon vos besoins -->
        <button onclick="modifierloccataire()">Modifier</button>
        <button onclick="supprimerLocataire()">supprimer</button>
    </div>
</body>
</html>
