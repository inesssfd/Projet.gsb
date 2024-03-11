<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <title>Accueil Demandeur</title>
</head>
<body>

<nav>
    <ul>
        <li><a href="../vue/profil_loccataire.php">Profil du locataire</a></li>
        
        <div>
    Bienvenue,
    <?php
    if (isset($_SESSION['login_loc'])) {
        echo $_SESSION['login_loc'];

        // Check if user ID is set and then display it
        if (isset($_SESSION['user_id'])) {
            echo ' (ID: ' . $_SESSION['user_id'] . ')';
        }
    } else {
        echo 'Invité';
    }
    ?>
    | <a href="../modele/deconnexion.php">Déconnexion</a>
</div>
    </ul>
</nav>

<?php
include_once '..\controleur\param_connexion.php';
include_once '..\modele\modele_loc.php';
include_once '..\modele\modele_app.php';

if (isset($_SESSION['login_loc'])) {
    $locataire = new Locataire();
    $appartements = $locataire->getAppartementsLocataire($_SESSION['login_loc']);

    echo '<div class="appartements-container">';
    echo '<h2 class="appartements-title">Appartements du locataire</h2>';

    foreach ($appartements as $appartement) {
        echo '<div class="appartement-proprio">';
        echo '<div class="appartement-info">';
        echo '<span class="appartement-label">Numéro d\'appartement:</span> ' . $appartement->getNumAppt() . '<br>';
        echo '<span class="appartement-label">Type d\'appartement:</span> ' . $appartement->getTypeAppt() . '<br>';
        echo '<span class="appartement-label">Prix de location:</span> ' . $appartement->getPrixLoc() . '<br>';
        echo '</div>';
        echo '</div>';
    }

    if (empty($appartements)) {
        echo '<p class="no-appartement">Aucun appartement trouvé pour le locataire.</p>';
    }

    echo '</div>';
} else {
    echo '<p class="welcome-message">Bienvenue, Invité. Veuillez vous connecter.</p>';
}
?>
</body>
</html>
