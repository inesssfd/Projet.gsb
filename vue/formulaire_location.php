<?php
session_start();
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
<title>Location</title>
    <meta name="Author" content="Iness Safady">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../style/style_appartement.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h1>Location</h1>
        <form method="POST" action="../controleur/controleur_locc.php" enctype="application/x-www-form-urlencoded">
            <?php if (!empty($confirmation)) : ?>
                <script>
                    alert('<?php echo $confirmation; ?>');
                </script>
            <?php endif; ?>
            
            <div class="input-wrapper">
                <label for="prenom_loc">Prénom:</label>
                <input type="text" id="prenom_loc" name="prenom_loc" value="<?php echo isset($_SESSION['prenom']) ? htmlspecialchars($_SESSION['prenom']) : ''; ?>" required>
            </div>

            <div class="input-wrapper">
                <label for="nom_loc">Nom:</label>
                <input type="text" id="nom_loc" name="nom_loc" value="<?php echo isset($_SESSION['nom']) ? htmlspecialchars($_SESSION['nom']) : ''; ?>" required>
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
                <input type="text" id="login_loc" name="login_loc" value="<?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : ''; ?>" readonly>
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