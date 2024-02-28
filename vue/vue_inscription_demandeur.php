<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Gestion de propriétaires</title>
    <meta name="Author" content="Iness safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Appel de la feuille de style (laissez l'attribut href vide si vous n'avez pas encore de feuille de style) -->
    <link href="../style/style_formualaire.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
    <table>
        <h1>Inscription demandeur</h1>
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
        <form method="POST" action="..\controleur\controleur_demandeurs.php" enctype="application/x-www-form-urlencoded">
            <input type="hidden" name="action" value="inscription"> <!-- Champ caché pour spécifier l'action d'inscription -->
            <tr>
                <td>Nom de demandeur: </td>
                <td><input type='text' name='nom_demandeur' size='20'></td>
            </tr>
            <tr>
                <td>Prénom : </td>
                <td><input type='text' name='prenom_demandeur' size='20' value=''></td>
            </tr>
            <tr>
                <td>Adresse : </td>
                <td><input type='text' name='adresse_demandeur' size='20' value=''></td>
            </tr>
            <tr>
                <td>Code postal : </td>
                <td><input type='text' name='cp_demandeur' size='20' value=''></td>
            </tr>
            <tr>
                <td>Téléphone : </td>
                <td><input type='text' name='tel_demandeur' size='20' value=''></td>
            </tr>
            <tr>
                <td>Login :</td>
                <td><input type='text' name='login' size='20' value=''></td>
            </tr>
            <tr>
                <td>Mot de passe : </td>
                <td><input type='text' name='motdepasse_demandeur' size='64' value=''></td>
            </tr>
            <td colspan="2"><input type='submit' value='Ajouter'></td>
            </tr>
        </form>
    </table>
</body>
</html>
