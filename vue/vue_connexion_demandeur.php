<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gestion de visite</title>
 <meta NAME="Author" CONTENT="Iness Safady">
 <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
 <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
<div class="container">
        <div class="form-container">
<form method='POST' action='../controleur/controleur_demandeurs.php' name='annuaire' enctype='application/x-www-form-urlencoded'>
    <h1>Connexion</h1>
    <div class="input-wrapper">
    <label for="login">login: </label>
	<input type='text' name='login' size='20' value=''>
  </div>
<div class="input-wrapper">
<label for="motdepasse_demandeur">motdepasse: </label>
    <input type='password' name='motdepasse_demandeur' size='20' value='' class='password-input'>
  </div>
<div class="input-wrapper">
<td colspan="2"><input type='submit' name='action' value='connexion' class='btn-connexion'>
  </div>
<div class="input-wrapper">
  <td colspan="2"><a href="../vue/vue_inscription_demandeur.php">Vous n'avez pas de compte ? </a>
  </div>

</form>
</div>
    </div>
</body>
</html>
