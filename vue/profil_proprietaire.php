<?php
// Inclure le contrôleur pour obtenir les détails du propriétaire
include_once '../controleur/controleur_proprietaire.php';
// Créer une instance de ProprietaireController
$controller = new ProprietaireController();

// Appel de la méthode pour obtenir les détails du propriétaire
$details_proprietaire = $controller->getDetailsProprietaire();
$loyerTotal = $controller->recupererLoyerTotal();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../style/script.js" defer></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_appartement.css">
    <title>Profil du Propriétaire</title>
</head>
<nav>
    <ul>
        <li><a href="v_acceuil_pro.php">Accueil</a></li>
        <li><a href="profil_proprietaire.php">Profil du proprietaire</a></li>
        <li><a href="ajouter_logement.php">Ajouter un appartement</a></li>
        
        <div>
<a href="../modele/deconnexion.php">Déconnexion</a>
</div>
    </ul>
</nav>


<body>
    <div id="profil" class="cbody">
        <h2>Profil du Propriétaire</h2>
        <?php if (!empty($details_proprietaire)) : ?>
            <ul>
                <li><strong>Nom:</strong> <span id="nom_prop" contenteditable="true"><?php echo $details_proprietaire['nom_prop']; ?></span></li>
                <li><strong>Prénom:</strong> <span id="prenom_prop" contenteditable="true"><?php echo $details_proprietaire['prenom_prop']; ?></span></li>
                <li><strong>Adresse:</strong> <span id="adresse_prop" contenteditable="true"><?php echo $details_proprietaire['adresse_prop']; ?></span></li>
                <li><strong>Code postal:</strong> <span id="cp_prop" contenteditable="true"><?php echo $details_proprietaire['cp_prop']; ?></span></li>
                <li><strong>Téléphone:</strong> <span id="tel_prop" contenteditable="true"><?php echo $details_proprietaire['tel_prop']; ?></span></li>
                <li><strong>Login:</strong> <span id="login_prop" contenteditable="true"><?php echo $details_proprietaire['login_prop']; ?></span></li>
                
            </ul>
            <div class="button-container">
                <button onclick="modifierProprietaire()">Modifier</button>
                <button onclick="supprimerProprietaire()">Supprimer</button>
            </div>

            <!-- Section pour afficher le loyer -->
            <h2>Loyer Mensuel</h2>
            <?php if ($loyerTotal) : ?>
                <p>Loyer mensuel total pour le propriétaire <?php echo $details_proprietaire['nom_prop'] . ' ' . $details_proprietaire['prenom_prop']; ?>: <?php echo $loyerTotal['loyer_total']; ?> euros</p>
            <?php else : ?>
                <p>Aucune information sur le loyer mensuel n'a été trouvée.</p>
            <?php endif; ?>
        <?php else : ?>
            <p>Les détails du propriétaire ne sont pas disponibles.</p>
        <?php endif; ?>
    </div>
</body>

</html>
