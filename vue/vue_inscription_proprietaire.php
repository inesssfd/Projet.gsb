<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Gestion de propriétaires</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Appel de la feuille de style -->
    <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>

<body>
<div class="container">
        <div class="form-container">
        <h1>Inscription Propriétaire</h1> <!-- Titre centré -->
<form method="POST" action="../controleur/controleur_proprietaire.php" enctype="application/x-www-form-urlencoded">
<?php
$error = $_GET['error'] ?? ''; // Utilisation de l'opérateur de fusion null pour gérer le cas où $_GET['error'] n'est pas défini

// Vérifier si $error est un tableau
if (is_array($error)) {
    // Gérer le cas où $error est un tableau
    foreach ($error as $errorMessage) {
        echo '<span class="error-message">Erreur: ' . $errorMessage . '</span><br>';
    }
} else {
    // Gérer le cas où $error est une chaîne de caractères
    if (strpos($error, 'nom_prop') !== false) {
        echo '<span class="error-message">Erreur: ' . $error . '</span><br>';
    }
}
?>
        <input type="hidden" name="action" value="inscription">
            <div class="input-wrapper">
                <label for="nom_prop">Nom :</label>
                <input type='text' name='nom_prop' id="nom_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="prenom_prop">Prénom :</label>
                <input type='text' name='prenom_prop' id="prenom_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="adresse_prop">Adresse :</label>
                <input type='text' name='adresse_prop' id="adresse_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="cp_prop">Code postal :</label>
                <input type='text' name='cp_prop' id="cp_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="tel_prop">Téléphone :</label>
                <input type='text' name='tel_prop' id="tel_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="login_prop">Login :</label>
                <input type='text' name='login_prop' id="login_prop" size='20'>
            </div>
            <div class="input-wrapper">
                <label for="motdepasse_pro">Mot de passe :</label>
                <input type='password' name='motdepasse_pro' id="motdepasse_pro" size='20'>
            </div>
            <input type='submit' value='Ajouter'>
        </form>
        </div>
    </div>
</body>

</html>
