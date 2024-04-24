<?php
include_once '../controleur/profil_proprietaire.php';
$num_proprietaire_connecte = isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : null;
if (!isset($_SESSION['numero_prop'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../style/script.js" defer></script>
    <script src="../style/proprietaire.js" defer></script>
    <link rel="stylesheet" href="../style/style_appartement.css">
    <title>Profil du Propriétaire</title>
</head>
<body>
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

    <div id="profil" class="cbody">
    <h2>Profil du Propriétaire</h2>
    <?php if ($details_proprietaire): ?>
        <ul>
        <li><strong>Nom:</strong> <span id="nom_prop" contenteditable="true"><?php echo $details_proprietaire['nom_prop']; ?></span></li>
        <li><strong>Prénom:</strong> <span id="prenom_prop" contenteditable="true"><?php echo $details_proprietaire['prenom_prop']; ?></span></li>
        <li><strong>Adresse:</strong> <span id="adresse_prop" contenteditable="true"><?php echo $details_proprietaire['adresse_prop']; ?></span></li>
        <li><strong>Code postal:</strong> <span id="cp_prop" contenteditable="true"><?php echo $details_proprietaire['cp_prop']; ?></span></li>
        <li><strong>Téléphone:</strong> <span id="tel_prop" contenteditable="true"><?php echo $details_proprietaire['tel_prop']; ?></span></li>
        </ul>
        <div class="button-container">
        <button onclick="modifierProprietaire()">Modifier</button>
            <button onclick="supprimerProprietaire()">Supprimer</button>
        </div>
        <div id="profil" class="cbody">
        <h2>Locataires</h2>
        <?php if ($loyerTotal): ?>
            <?php foreach ($loyerTotal as $locataire): ?>
                <div>
                    <h3>Nom du Locataire: <?php echo $locataire['nom_loc'] . ' ' . $locataire['prenom_loc']; ?></h3>
                    <p>Numéro d'Appartement: <?php echo $locataire['num_appt']; ?></p>
                    <p>Loyer Total: <?php echo $locataire['loyer_total']; ?> €</p>
                    <p>Prix du Loyer: <?php echo $locataire['prix_loyer']; ?> €</p>
                    <p>Prix des Charges: <?php echo $locataire['prix_charges']; ?> €</p>
                </div>
            <?php endforeach; ?>
            <?php
                // Calcul du total des loyers
                $totalLoyer = array_sum(array_column($loyerTotal, 'loyer_total'));
            ?>
            <div>
                <h3>Total des Loyers Regroupés:</h3>
                <p><?php echo $totalLoyer; ?> €</p>
            </div>
        <?php else: ?>
            <p>Aucun locataire trouvé.</p>
        <?php endif; ?>
    <?php endif; ?>
</div> <!-- Fermeture de la balise div -->
<script>
        function modifierProprietaire() {
    var nouveauNom = document.getElementById('nom_prop').innerText;
    var nouveauPrenom = document.getElementById('prenom_prop').innerText;
    var nouvelleAdresse = document.getElementById('adresse_prop').innerText;
    var nouveauCodePostal = document.getElementById('cp_prop').innerText;
    var nouveauTelephone = document.getElementById('tel_prop').innerText;
    //var nouveauLogin = document.getElementById('login_prop').innerText;
    var num_proprietaire_connecte = <?php echo json_encode($num_proprietaire_connecte); ?>;
    console.log("Nouveau nom : " + nouveauNom);
    console.log("Nouveau prénom : " + nouveauPrenom);
    console.log("Nouveau adresse_prop : " + nouveauCodePostal);
    console.log("Nouveau nouveauCodePostal : " + nouveauCodePostal);
    console.log("Nouveau nouveauTelephone : " + nouveauTelephone);
    console.log("Nouveau num_proprietaire_connecte : " + num_proprietaire_connecte);

// Création d'un objet pour stocker les paramètres à envoyer
var params = {
    num_proprietaire_connecte: num_proprietaire_connecte
};

    // Vérification des valeurs et ajout aux paramètres non nuls
    if (nouveauNom !== null && nouveauNom !== "") {
        params.nouveauNom = nouveauNom;
    }
    if (nouveauPrenom !== null && nouveauPrenom !== "") {
        params.nouveauPrenom = nouveauPrenom;
    }
    if (nouvelleAdresse !== null && nouvelleAdresse !== "") {
        params.nouvelleAdresse = nouvelleAdresse;
    }
    if (nouveauCodePostal !== null && nouveauCodePostal !== "") {
        params.nouveauCodePostal = nouveauCodePostal;
    }
    if (nouveauTelephone !== null && nouveauTelephone !== "") {
        params.nouveauTelephone = nouveauTelephone;
    }

    // Vérifier si des paramètres ont été ajoutés avant d'envoyer la requête AJAX
    if (Object.keys(params).length > 0) {
        // Envoi des nouvelles valeurs au serveur via une requête AJAX
// Envoi des nouvelles valeurs au serveur via une requête AJAX
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        console.log("Réponse complète du serveur : " + xhr.responseText); // Afficher la réponse complète du serveur dans la console
        if (xhr.status == 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                console.log("Réponse JSON analysée : ", response); // Afficher la réponse JSON analysée
                if (response.status === 'success') {
                    alert("Profil du propriétaire modifié avec succès!");
                    // Actualisez la page ou effectuez d'autres actions après la modification
                } else if (response.status === 'error') {
                    alert("Erreur lors de la modification du profil du propriétaire : " + response.message);
                } else {
                    alert("Réponse inattendue du serveur.");
                }
            } catch (error) {
                console.error("Erreur lors de l'analyse de la réponse JSON : " + error); // Afficher les erreurs d'analyse JSON
            }
        } else {
            alert("Erreur de modification du profil du propriétaire. Statut HTTP : " + xhr.status);
        }
    }
};

// Convertir l'objet params en JSON
var jsonData = JSON.stringify(params);

// Ouverture de la requête AJAX et envoi avec le JSON
xhr.open("GET", "../controleur/profil_proprietaire.php?action=modifierProprietaireHandler&jsonData=" + encodeURIComponent(jsonData), true);
xhr.setRequestHeader("Content-Type", "application/json");
xhr.send(jsonData);

    } else {
        console.error("Aucune nouvelle valeur fournie.");
    }
}
</script>

</body>
</html>
