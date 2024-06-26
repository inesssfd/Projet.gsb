<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <script src="../style/script.js" defer></script>
    <title>Demande du Demandeur</title>
</head>
<body class="cbody">

<nav>
    <ul>
        <li><a href="v_acceuil_demandeur.php">Accueil</a></li>
        <li><a href="appartement_loué.php">Visite et profil du Demandeur</a></li>
        <div>Bienvenue, <?php echo isset($_SESSION['login']) ? $_SESSION['login'] : 'Invité'; ?> | 
    Numéro du demandeur : <?php echo isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : 'Invité'; ?> | 
    <a href="../modele/deconnexion.php">Déconnexion</a>
</div>
</nav>

<body>
    <h1>Demande de Location</h1>
    <form method="POST" action="../controleur/traitement_demande_location.php">
        <input name="num_appt" value="<?php echo isset($_GET['num_appt']) ? htmlspecialchars($_GET['num_appt']) : ''; ?>">

        <label for="date_demande">Date de la demande :</label>
        <!-- Utilisation de PHP pour définir la valeur par défaut à la date d'aujourd'hui -->
        <input type="date" id="date_demande" name="date_demande" value="<?php echo date('Y-m-d'); ?>" required readonly>


        <input type="submit" value="Envoyer la demande">
    </form>
</body>
</html>
