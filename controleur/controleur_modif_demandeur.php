<?php
include_once '../modele/modele_demandeur.php';
session_start();

class ModifierDemandeurHandler {
    private $demandeur;

    public function __construct() {
        $this->demandeur = new Demandeurs();
    }

    public function modifierDemandeur() {
        // Vérification de l'action dans les paramètres GET
        if (isset($_GET['action']) && $_GET['action'] == 'modifierDemandeur') {
            // Récupérer le numéro du demandeur connecté depuis la session
            $num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

            $nouveauNom = isset($_POST['nouveauNom']) ? $_POST['nouveauNom'] : null;
            $nouveauPrenom = isset($_POST['nouveauPrenom']) ? $_POST['nouveauPrenom'] : null;
            $nouvelleAdresse = isset($_POST['nouvelleAdresse']) ? $_POST['nouvelleAdresse'] : null;
            $nouveauCodePostal = isset($_POST['nouveauCodePostal']) ? $_POST['nouveauCodePostal'] : null;
            $nouveauTelephone = isset($_POST['nouveauTelephone']) ? $_POST['nouveauTelephone'] : null;

            // Appel de la méthode de modification avec le numéro du demandeur connecté
            $this->demandeur->modifierDemandeur($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_demandeur_connecte);
        }
    }
}

// Création d'une instance de la classe et appel de la méthode
$handler = new ModifierDemandeurHandler();
$handler->modifierDemandeur();
?>
