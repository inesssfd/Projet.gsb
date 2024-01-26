<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Gestion de propriétaires</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Appel de la feuille de style (laissez l'attribut href vide si vous n'avez pas encore de feuille de style) -->
    <link href="../style/style_formualaire.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
    <h1>Inscription Propriétaire</h1>
    <form method="POST" action="..\controleur\controleur_inscription_proprietaire.php" enctype="application/x-www-form-urlencoded" class="container center-form">
        <table>
            <tr>
                <td><label for="nom_prop">Nom :</label></td>
                <td><input type='text' name='nom_prop' id="nom_prop" size='20'></td>
            </tr>
            <tr>
                <td><label for="prenom_prop">Prénom :</label></td>
                <td><input type='text' name='prenom_prop' id="prenom_prop" size='20' value=''></td>
            </tr>
            <tr>
                <td><label for="adresse_prop">Adresse :</label></td>
                <td><input type='text' name='adresse_prop' id="adresse_prop" size='20' value=''></td>
            </tr>
            <tr>
                <td><label for="cp_prop">Code postal :</label></td>
                <td><input type='text' name='cp_prop' id="cp_prop" size='20' value=''></td>
            </tr>
            <tr>
                <td><label for="tel_prop">Téléphone :</label></td>
                <td><input type='text' name='tel_prop' id="tel_prop" size='20' value=''></td>
            </tr>
            <tr>
                <td><label for="login_prop">Login :</label></td>
                <td><input type='text' name='login_prop' id="login_prop" size='20' value=''></td>
            </tr>
            <tr>
                <td><label for="motdepasse_pro">Mot de passe :</label></td>
                <td><input type='password' name='motdepasse_pro' id="motdepasse_pro" size='20' value=''></td>
            </tr>
            <tr>
                <td colspan="2"><input type='submit' value='Ajouter'></td>
            </tr>
        </table>
    </form>
</body>

</html>
