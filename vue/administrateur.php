<?php
include_once '../controleur/controleur_admin.php';
$data = afficherVueAdmin();
$demandeurs = $data['demandeurs'];
$proprietaires = $data['proprietaires'];
$locataire = $data['locataire'];
$appartement = $data['appartement'];
$visite = $data['visite'];
$chiffreAffairesTotal = $data['chiffreAffairesTotal']; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="icon" type="image/x-icon" href="data:," />
    <link rel="stylesheet" href="../style/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../style/script.js" defer></script>
    <script src="../style/appartement.js" defer></script>
    <script src="../style/proprietaire.js" defer></script>
    <script src="../style/locataire.js" defer></script>
</head>
<body>
    <div class="tabs">
    <button class="tablink" onclick="openTab('demandeurs', event)">Tous les Demandeurs</button>
<button class="tablink" onclick="openTab('proprietaires', event)">Tous les Propriétaires</button>
<button class="tablink" onclick="openTab('locataires', event)">Tous les locataires</button>
<button class="tablink" onclick="openTab('appartements', event)">Tous les appartements</button>
<button class="tablink" onclick="openTab('visites', event)">Toutes les visites </button>
<button class="tablink" onclick="openTab('chiffreAffaires', event)">Chiffre d'affaires</button>
<a href="../modele/deconnexion.php" class="logout">Déconnexion</a>


    </div>

    <div id="demandeurs" class="tabcontent">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Téléphone</th>
                <th>Login</th>
            </tr>
            <?php $index = 0; ?>
<?php foreach ($demandeurs as $demandeur) : ?>
    <tr>
        <td contenteditable="true" id="nom_demandeur<?= $index ?>"><?= $demandeur['nom_demandeur'] ?></td>
        <td contenteditable="true" id="prenom_demandeur<?= $index ?>"><?= $demandeur['prenom_demandeur'] ?></td>
        <td contenteditable="true" id="adresse_demandeur<?= $index ?>"><?= $demandeur['adresse_demandeur'] ?></td>
        <td contenteditable="true" id="cp_demandeur<?= $index ?>"><?= $demandeur['cp_demandeur'] ?></td>
        <td contenteditable="true" id="tel_demandeur<?= $index ?>"><?= $demandeur['tel_demandeur'] ?></td>
        <td contenteditable="true" id="login_demandeur<?= $index ?>"><?= $demandeur['login'] ?></td>
        <td><button onclick="modifierDemandeurAdmin(<?= $index ?>)">Modifier</button></td>
        <td><button onclick="supprimerDemandeur(<?= $demandeur['num_demandeur'] ?>)">Supprimer</button></td>

    </tr>
    <?php $index++; ?>
<?php endforeach; ?>

        </table>
    </div>

    <div id="proprietaires" class="tabcontent">
    <table>
        <tr>
            <th>id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Téléphone</th>
            <th>Login</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($proprietaires as $index => $proprietaire) : ?>
            <tr>         
                <td><?= $proprietaire['numero_prop'] ?></td>       
                <td contenteditable="true" id="nom_prop<?= $index ?>"><?= $proprietaire['nom_prop'] ?></td>
                <td contenteditable="true" id="prenom_prop<?= $index ?>"><?= $proprietaire['prenom_prop'] ?></td>
                <td contenteditable="true" id="adresse_prop<?= $index ?>"><?= $proprietaire['adresse_prop'] ?></td>
                <td contenteditable="true" id="cp_prop<?= $index ?>"><?= $proprietaire['cp_prop'] ?></td>
                <td contenteditable="true" id="tel_prop<?= $index ?>"><?= $proprietaire['tel_prop'] ?></td>
                <td contenteditable="true" id="login_prop<?= $index ?>"><?= $proprietaire['login_prop'] ?></td>
                <td>
                    <button onclick="modifierProprietaireAdmin(<?= $index ?>)">Modifier</button></td>
                    <button onclick="supprimerProprietaireAdmin(<?= $proprietaire['numero_prop'] ?>)">Supprimer</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
    

<div id="locataires" class="tabcontent">
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Téléphone</th>
            <th>Numéro Bancaire</th>
            <th>Nom de Banque</th>
            <th>Code Postal de Banque</th>
            <th>Téléphone de Banque</th>
            <th>Login</th>
            <th>Actions</th>
        </tr>
        <?php $index = 0; ?>
        <?php foreach ($locataire as $loc) : ?>
            <tr>
                <td contenteditable="true" id="nom_loc<?= $index ?>"><?= $loc['nom_loc'] ?></td>
                <td contenteditable="true" id="prenom_loc<?= $index ?>"><?= $loc['prenom_loc'] ?></td>
                <td contenteditable="true" id="date_nais<?= $index ?>"><?= $loc['date_nais'] ?></td>
                <td contenteditable="true" id="tel_loc<?= $index ?>"><?= $loc['tel_loc'] ?></td>
                <td contenteditable="true" id="num_bancaire<?= $index ?>"><?= $loc['num_bancaire'] ?></td>
                <td contenteditable="true" id="nom_banque<?= $index ?>"><?= $loc['nom_banque'] ?></td>
                <td contenteditable="true" id="cp_banque<?= $index ?>"><?= $loc['cp_banque'] ?></td>
                <td contenteditable="true" id="tel_banque<?= $index ?>"><?= $loc['tel_banque'] ?></td>
                <td contenteditable="true" id="login_loc<?= $index ?>"><?= $loc['login_loc'] ?></td>
                <td><button onclick="modifierLocataireAdmin(<?= $loc['num_loc'] ?>, <?= $index ?>)">Modifier</button></td>
                <td><button onclick="supprimerLocataireAdmin(<?= $loc['num_loc'] ?>)">Supprimer</button></td>
            </tr>
            <?php $index++; ?>
        <?php endforeach; ?>
    </table>
</div>

    <div id="appartements" class="tabcontent">
    <table>
        <tr>
            <th>Numéro d'Appartement</th>
            <th>Type</th>
            <th>Prix de Location</th>
            <th>Prix des Charges</th>
            <th>Rue</th>
            <th>Arrondissement</th>
            <th>Étage</th>
            <th>Ascenseur</th>
            <th>Préavis</th>
            <th>Date Libre</th>
            <th>Numéro de Propriétaire</th>
        </tr>
        <?php foreach ($appartement as $apt) : ?>
            <tr>
                <td><?= $apt->getNumAppt() ?></td>
                <td contenteditable="true" id="type_appt_<?= $apt->getNumAppt() ?>"><?= $apt->getTypeAppt() ?></td>
                <td contenteditable="true" id="prix_loc_<?= $apt->getNumAppt() ?>"><?= $apt->getPrixLoc() ?></td>
                <td contenteditable="true" id="prix_charge_<?= $apt->getNumAppt() ?>"><?= $apt->getPrixCharge() ?></td>
                <td contenteditable="true" id="rue_<?= $apt->getNumAppt() ?>"><?= $apt->getRue() ?></td>
                <td><?= $apt->getArrondisement() ?></td>
                <td><?= $apt->getEtage() ?></td>
                <td><?= $apt->getAscenceur() ?></td>
                <td><?= $apt->getPreavis() ?></td>
                <td><?= $apt->getDateLibre() ?></td>
                <td><?= $apt->getNumeroProp() ?></td>
                <td>
                <button onclick="supprimerAppartement(<?= $apt->getNumAppt() ?>)">Supprimer</button>
                <button onclick="modifierAppartement(<?= $apt->getNumAppt() ?>, <?= $apt->getNumeroProp() ?>)">Modifier</button>

        </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div id="visites" class="tabcontent">
    <table>
        <tr>
            <th>id de visite</th>
            <th>numéro du demandeur</th>
            <th>date de visite</th>
            <th>le numero d'appartement</th>

        </tr>
        <?php foreach ($visite as $visite) : ?>
                <tr>
                    <tr id="visite_<?= $visite['id_visite'] ?>" class="visite">
                    <td><?= $visite['num_demandeur'] ?></td>
                    <td><?= $visite['date_visite'] ?></td>
                    <td><?= $visite['num_appt'] ?></td>
                    <td>
                    <button onclick="supprimerVisiteAdmin(<?= $visite['id_visite'] ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div id="chiffreAffaires" class="tabcontent">
    <h2>Chiffre d'affaires</h2>
    <!-- Ajoutez ici le contenu relatif au chiffre d'affaires -->
    <p>Chiffre d'affaires total : <?php echo $chiffreAffairesTotal; ?> €</p>
</div>
<script>

function openTab(tabName, event) {
    // Cacher tous les onglets et désactiver tous les tablinks
    var tabcontent = document.getElementsByClassName("tabcontent");
    var tablinks = document.getElementsByClassName("tablink");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
        tablinks[i].classList.remove("active");
    }
    // Afficher l'onglet sélectionné et activer le tablink correspondant
    document.getElementById(tabName).classList.add("active");
    event.currentTarget.classList.add("active");
}

</script>
</body>
</html>
