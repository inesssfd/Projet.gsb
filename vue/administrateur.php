<?php
// Inclure le contrôleur pour récupérer les données
include_once '../controleur/controleur_admin.php';
// Instancier le contrôleur et récupérer les données
$adminController = new AdminController();
$data = $adminController->afficherVueAdmin();
$demandeurs = $data['demandeurs'];
$proprietaires = $data['proprietaires'];
$locataire = $data['locataire'];
$appartement = $data['appartement'];
$visite = $data['visite'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="icon" type="image/x-icon" href="data:," />
    <link rel="stylesheet" href="../style/admin.css">
    <script src="../style/script.js" defer></script>
</head>
<body>
    <div class="tabs">
    <button class="tablink" onclick="openTab('demandeurs', event)">Tous les Demandeurs</button>
<button class="tablink" onclick="openTab('proprietaires', event)">Tous les Propriétaires</button>
<button class="tablink" onclick="openTab('locataires', event)">Tous les locataires</button>
<button class="tablink" onclick="openTab('appartements', event)">Tous les appartements</button>
<button class="tablink" onclick="openTab('visites', event)">Toutes les visites </button>

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
        <button onclick="modifierDemandeurAdmin(<?= $index ?>)">Modifier</button>
        <button onclick="supprimerDemandeur(<?= $demandeur['num_demandeur'] ?>)">Supprimer</button>

    </tr>
    <?php $index++; ?>
<?php endforeach; ?>

        </table>
    </div>

    <div id="proprietaires" class="tabcontent">
        <table>
            <tr><th>id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Téléphone</th>
                <th>Login</th>
            </tr>
            <?php foreach ($proprietaires as $index => $proprietaire) : ?>
    <tr>         
    <td id="numero_prop<?= $index ?>"><?= $proprietaire['numero_prop'] ?></td>       
        <td contenteditable="true" id="nom_prop<?= $index ?>"><?= $proprietaire['nom_prop'] ?></td>
        <td contenteditable="true" id="prenom_prop<?= $index ?>"><?= $proprietaire['prenom_prop'] ?></td>
        <td contenteditable="true" id="adresse_prop<?= $index ?>"><?= $proprietaire['adresse_prop'] ?></td>
        <td contenteditable="true" id="cp_prop<?= $index ?>"><?= $proprietaire['cp_prop'] ?></td>
        <td contenteditable="true" id="tel_prop<?= $index ?>"><?= $proprietaire['tel_prop'] ?></td>
        
        <td contenteditable="true" id="login_prop<?= $index ?>"><?= $proprietaire['login_prop'] ?></td>
        <td>
        <button onclick="supprimerProprietaireAdmin(<?= $proprietaire['numero_prop'] ?>)">Supprimer</button>

        </td>
    </tr>
<?php endforeach; ?>

        </table>
    </div>
    <div id="locataires" class="tabcontent">
        <table>
            <tr>
                <th>Numéro de Locataire</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Naissance</th>
                <th>Téléphone</th>
                <th>Numéro Bancaire</th>
                <th>Nom de Banque</th>
                <th>Code Postal de Banque</th>
                <th>Téléphone de Banque</th>
                <th>Login</th>
            </tr>
            <?php foreach ($locataire as $locataire) : ?>
                <tr>
                    <td><?= $locataire['num_loc'] ?></td>
                    <td><?= $locataire['nom_loc'] ?></td>
                    <td><?= $locataire['prenom_loc'] ?></td>
                    <td><?= $locataire['date_nais'] ?></td>
                    <td><?= $locataire['tel_loc'] ?></td>
                    <td><?= $locataire['num_bancaire'] ?></td>
                    <td><?= $locataire['nom_banque'] ?></td>
                    <td><?= $locataire['cp_banque'] ?></td>
                    <td><?= $locataire['tel_banque'] ?></td>
                    <td><?= $locataire['login_loc'] ?></td>
                    <td>
                    <button onclick="supprimerLocataireAdmin(<?= $locataire['num_loc'] ?>)">Supprimer</button>
                    </td>
                </tr>
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
