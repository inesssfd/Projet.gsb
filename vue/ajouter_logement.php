<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Appartement</title>
    <link rel="stylesheet" href="../style/style_acceuil.css">
<link rel="stylesheet" href="../style/style_formualaire.css">

</head>

<body>
<nav>
        <ul>
            <li><a href="profil_proprietaire.php">Profil</a></li>
            <li><a href="ajouter_logement.php">Ajouter un Logement</a></li>
            <div>Bienvenue, <?php echo (isset($_SESSION['login_prop']) ? $_SESSION['login_prop'] : 'Invité'); ?> | <span>Propriétaire ID: <?php echo (isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : 'N/A'); ?></span> | <a href="../modele/deconnexion.php">Déconnexion</a></div>
        </ul>
    </nav>
    <form method="POST" action="../controleur/controleur_nvl_app.php" class="center-form">
    <h1>Ajouter un Appartement</h1>

    <label for="type_appt">Type d'Appartement:</label>
    <input type="text" id="type_appt" name="type_appt" required>

    <label for="prix_loc">Prix de Location:</label>
    <input type="text" id="prix_loc" name="prix_loc" required>

    <label for="prix_charge">Prix des Charges:</label>
    <input type="text" id="prix_charge" name="prix_charge" required>

    <label for="rue">Rue:</label>
    <input type="text" id="rue" name="rue" required>

    <label for="arrondisement">Arrondissement:</label>
    <input type="text" id="arrondisement" name="arrondisement" required>

    <label for="etage">Étage:</label>
    <input type="text" id="etage" name="etage" required>

    <label for="ascenseur">Ascenseur:</label>
    <select id="ascenseur" name="ascenseur" required>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>

    <label for="preavis">Préavis:</label>
    <select id="preavis" name="preavis" required>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>

    <label for="date_libre">Date Libre:</label>
    <input type="date" id="date_libre" name="date_libre" required>

    <label for="numero_prop">Numéro du Propriétaire :</label>
<input type="hidden" id="numero_prop" name="numero_prop" value="<?php echo isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : ''; ?>">
<span><?php echo isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : ''; ?></span> <!-- Affichage pour confirmation (facultatif) -->

    <input type="submit" value="Ajouter Appartement">
</form>

</body>
</html>
