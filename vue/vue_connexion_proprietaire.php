<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gestion de visite</title>
 <meta NAME="Author" CONTENT="Iness Safady">
 <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
  <!-- appel feuille de style -->
 <link href="../style/connexion.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
<table>
<form method='POST' action='../controleur/controleur_proprietaire.php' name='annuaire' enctype='application/x-www-form-urlencoded'>
<input type="hidden" name="action" value="connexion">
    <h1>Connexion</h1>
<tr>
	<td>Login : </td>
	<td><input type='text' name='login_prop' size='20' value=''></td>
</tr>
<tr>
	<td>Mot de passe : </td>
	<td><input type='password' name='motdepasse_pro' size='20' value=''></td>
</tr>
<tr>
<td colspan="2"><input type='submit' value='Connexion'></td>
</tr>
<tr>
  <td colspan="2"><a href="vue_inscription_proprietaire.php">Vous n'avez pas de compte ? </a></td>
</tr>

</form>
</table>
</body>
</html>