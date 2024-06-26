<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Gestion de propriétaires</title>
    <meta name="Author" content="Iness safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Appel de la feuille de style (laissez l'attribut href vide si vous n'avez pas encore de feuille de style) -->
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
        <h1>Inscription demandeur</h1>
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
        <form method="POST" action="..\controleur\controleur_demandeurs.php" enctype="application/x-www-form-urlencoded">
            <input type="hidden" name="action" value="inscription"> <!-- Champ caché pour spécifier l'action d'inscription -->
            <div class="input-wrapper">
                <label for="nom_demandeur">Nom de demandeur: </label>
                <input type='text' name='nom_demandeur' size='20'>
            </div>
            <div class="input-wrapper">
                <label for="prenom_demandeur"> Prénom : </label>
                <input type='text' name='prenom_demandeur' size='20' value=''id="prenom_demandeur">
            </div>
             <div class="input-wrapper">
                <label for="adresse_demandeur"> Adresse : </label>
                <input type='text' name='adresse_demandeur' size='20' value=''id="adresse_demandeur">
            </div>
             <div class="input-wrapper">
                <label  for="cp_demandeur">Code postal : </label>
                <input type='text' name='cp_demandeur' size='20' value='' id="cp_demandeur">
            </div>
             <div class="input-wrapper">
                <label  for="tel_demandeur">Téléphone : </label>
                <input type='text' name='tel_demandeur' size='20' value=''id="tel_demandeur">
            </div>
             <div class="input-wrapper">
                <label for="login">Login :</label>
                <input type='text' name='login' size='20' value=''id="login">
            </div>
             <div class="input-wrapper">
                <label for="motdepasse_demandeur">Mot de passe :</label>
                <input type='password' name='motdepasse_demandeur' size='64' value=''id="motdepasse_demandeur">
            </div>
            <td colspan="2"><input type='submit' value='Ajouter'></label>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
