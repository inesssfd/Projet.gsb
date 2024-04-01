<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
    <title>Connexion Admin</title>
</head>
<body>
<div class="container">
<div class="form-container">
    <h2>Connexion Admin</h2>
    <form action="../controleur/connexion_admin.php" method="post">
    <div class="input-wrapper">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-wrapper">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-wrapper">
            <button type="submit">Se connecter</button>
        </div>
    </form>
    </div>
    </div>
</body>
</html>
