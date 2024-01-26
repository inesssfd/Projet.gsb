<?php
include_once '../modele/modele_demandeur.php';
session_start();

function modifierDemandeurHandler() {
    // Vérification de l'action dans les paramètres GET
    if (isset($_GET['action']) && $_GET['action'] == 'modifierDemandeur') {
        // Récupérer le numéro du demandeur connecté depuis la session
        $num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

        // Création d'une instance de la classe demandeurs
        $demandeur = new demandeurs();

        $nouveauNom = isset($_POST['nouveauNom']) ? $_POST['nouveauNom'] : null;
        $nouveauPrenom = isset($_POST['nouveauPrenom']) ? $_POST['nouveauPrenom'] : null;
        $nouvelleAdresse = isset($_POST['nouvelleAdresse']) ? $_POST['nouvelleAdresse'] : null;
        $nouveauCodePostal = isset($_POST['nouveauCodePostal']) ? $_POST['nouveauCodePostal'] : null;
        $nouveauTelephone = isset($_POST['nouveauTelephone']) ? $_POST['nouveauTelephone'] : null;

        // Appel de la méthode de modification avec le numéro du demandeur connecté
        $demandeur->modifierDemandeur($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_demandeur_connecte);
    }
}

// Appel de la fonction si elle est directement demandée
modifierDemandeurHandler();
?>
