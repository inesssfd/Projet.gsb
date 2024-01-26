<?php
include_once '../modele/modele_proprietaire.php';
session_start();

function modifierProprietaireHandler() {
    // Vérification de l'action dans les paramètres GET
    if (isset($_GET['action']) && $_GET['action'] == 'modifierPropriétaire') {
        // Récupérer le numéro du demandeur connecté depuis la session
        $num_proprietaire_connecte = isset($_SESSION['numero_prop']) ? $_SESSION['numero_prop'] : null;

        // Création d'une instance de la classe demandeurs
        $proprietaire = new proprietaire();

        $nouveauNom = isset($_POST['nouveauNom']) ? $_POST['nouveauNom'] : null;
        $nouveauPrenom = isset($_POST['nouveauPrenom']) ? $_POST['nouveauPrenom'] : null;
        $nouvelleAdresse = isset($_POST['nouvelleAdresse']) ? $_POST['nouvelleAdresse'] : null;
        $nouveauCodePostal = isset($_POST['nouveauCodePostal']) ? $_POST['nouveauCodePostal'] : null;
        $nouveauTelephone = isset($_POST['nouveauTelephone']) ? $_POST['nouveauTelephone'] : null;
        $nouveauLogin = isset($_POST['nouveauLogin']) ? $_POST['nouveauLogin'] : null;

        // Appel de la méthode de modification avec le numéro du demandeur connecté
        $proprietaire->modifierPropriétaire($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone,$nouveauLogin, $num_proprietaire_connecte);
    }
}

// Appel de la fonction si elle est directement demandée
modifierProprietaireHandler();
?>
