
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <?php
// Inclure le contrôleur pour obtenir les détails du propriétaire
include_once '../controleur/controleur_proprietaire.php';
// Créer une instance de ProprietaireController
$controller = new ProprietaireController();
$num_proprietaire_connecte = isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : null;
// Appel de la méthode pour obtenir les détails du propriétaire
$details_proprietaire = $controller->getDetailsProprietaire();
$loyerTotal = $controller->recupererLoyerTotal();
        ?>
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
    <script>
        function modifierProprietaire() {
    var nouveauNom = document.getElementById('nom_prop').innerText;
    var nouveauPrenom = document.getElementById('prenom_prop').innerText;
    var nouvelleAdresse = document.getElementById('adresse_prop').innerText;
    var nouveauCodePostal = document.getElementById('cp_prop').innerText;
    var nouveauTelephone = document.getElementById('tel_prop').innerText;
    var nouveauLogin = document.getElementById('login_prop').innerText;
    var num_proprietaire_connecte = <?php echo json_encode($num_proprietaire_connecte); ?>;
    console.log("Nouveau nom : " + nouveauNom);
    console.log("Nouveau prénom : " + nouveauPrenom);
    console.log("Nouveau adresse_prop : " + nouveauCodePostal);
    console.log("Nouveau nouveauCodePostal : " + nouveauCodePostal);
    console.log("Nouveau nouveauTelephone : " + nouveauTelephone);
    console.log("Nouveau nouveauLogin : " + nouveauLogin);
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
    if (nouveauLogin !== null && nouveauLogin !== "") {
        params.nouveauLogin = nouveauLogin;
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
xhr.open("GET", "../controleur/controleur_modif_proprio.php?action=modifierProprietaireHandler&jsonData=" + encodeURIComponent(jsonData), true);
xhr.setRequestHeader("Content-Type", "application/json");
xhr.send(jsonData);

    } else {
        console.error("Aucune nouvelle valeur fournie.");
    }
}
</script>
