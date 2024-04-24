<?php
session_start();
if (!isset($_SESSION['num_demandeur'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Gestion de visite</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
</head>

<body>
<nav>
    <ul>
        <li><a href="v_acceuil_demandeur.php">Accueil</a></li>
        <li><a href="appartement_loué.php">visite et profil du Demandeur</a></li>
    <a href="../modele/deconnexion.php">Déconnexion</a>
</div>
    </ul>
</nav>
<title>Location</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
<div class="container">
    <div class="form-container">
    <h1>Location</h1>
    <?php
        // Afficher les messages d'erreur s'il y en a dans l'URL
        if (isset($_GET['error'])) {
            echo "<ul>";
            foreach ($_GET['error'] as $error) {
                echo "<li style='color: red;'>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        }
        ?>
        <form method="POST" action="../controleur/controleur_locc.php" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="action" value="inscription">
                        <div class="input-wrapper">
                <label for="prenom_loc">Prénom:</label>
                <input type="text" id="prenom_loc" name="prenom_loc" value="<?php echo isset($_SESSION['prenom_demandeur']) ? htmlspecialchars($_SESSION['prenom_demandeur']) : ''; ?>" required>
            </div>

            <div class="input-wrapper">
                <label for="nom_loc">Nom:</label>
                <input type="text" id="nom_loc" name="nom_loc" value="<?php echo isset($_SESSION['nom_demandeur']) ? htmlspecialchars($_SESSION['nom_demandeur']) : ''; ?>" required>
            </div>


            <div class="input-wrapper">
                <label for="date_nais">Date de naissance:</label>
                <input type="date" id="date_nais" name="date_nais" required>
            </div>

            <div class="input-wrapper">
                <label for="tel_loc">Téléphone:</label>
                <input type="tel" id="tel_loc" name="tel_loc" required>
            </div>

            <div class="input-wrapper">
                <label for="num_bancaire">Numéro de compte bancaire:</label>
                <input type="text" id="num_bancaire" name="num_bancaire" required>
            </div>

            <div class="input-wrapper">
                <label for="nom_banque">Nom de la banque:</label>
                <input type="text" id="nom_banque" name="nom_banque" required>
            </div>

            <div class="input-wrapper">
                <label for="cp_banque">Code postal de la banque:</label>
                <input type="text" id="cp_banque" name="cp_banque" required>
            </div>

            <div class="input-wrapper">
                <label for="tel_banque">Téléphone de la banque:</label>
                <input type="tel" id="tel_banque" name="tel_banque" required>
            </div>
            <div class="input-wrapper">
                <label for="login_loc">Identifiant de connexion:</label>
                <input type="text" id="login_loc" name="login_loc" value="<?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : ''; ?>" >
            </div>

            <div class="input-wrapper">
                <label for="motdepasse_loc">Mot de passe:</label>
                <input type="password" id="motdepasse_loc" name="motdepasse_loc" required>
            </div>

            <input type="hidden" name="num_appt" value="<?php echo isset($_GET['num_appt']) ? htmlspecialchars($_GET['num_appt']) : ''; ?>">
            <?php echo isset($_SESSION['num_demandeur']) ?>

            <input type="submit" name="submit" value="Louer">
        </form>
    </div>
</div>
</body>
</html>