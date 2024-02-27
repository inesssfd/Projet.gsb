<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Gestion de propriétaires</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Appel de la feuille de style -->
    <link href="../style/style_formualaire.css" type="text/css" rel="stylesheet" media="all">
</head>

<body>
    <div class="form-wrapper"> <!-- Div pour envelopper le formulaire -->
        <h1>Inscription Propriétaire</h1> <!-- Titre centré -->
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
        <form method="POST" action="..\controleur\controleur_prop.php" enctype="application/x-www-form-urlencoded">
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
</body>

</html>
