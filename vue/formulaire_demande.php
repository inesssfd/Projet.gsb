<?php
session_start();
if (!isset($_SESSION['num_demandeur']) && !isset($_SESSION['numero_prop'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
include_once '../modele/modele_demandeur.php';
// Récupérer le numéro du demandeur connecté depuis la session
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <script src="../style/script.js" defer></script>
    <title>demande du Demandeur</title>
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
<body>
    <h1>Demande de Location</h1>
    <form method="POST" action="../controleur/traitement_demande_location.php">
        <input type="hidden" name="num_appt" value="<?php echo isset($_GET['num_appt']) ? htmlspecialchars($_GET['num_appt']) : ''; ?>">
        <?php 
            echo isset($_SESSION['num_demandeur']) ? var_dump($_SESSION['num_demandeur']) : ''; 
        ?>

        <label for="date_demande">Date de la demande :</label>
        <input type="date" id="date_demande" name="date_demande" required>

        <input type="submit" value="Envoyer la demande">
    </form>
</body>
</html>
