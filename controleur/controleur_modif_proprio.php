<?php
include_once '../modele/modele_proprietaire.php';
session_start();

function modifierProprietaireHandler() {
    // Vérification de l'action dans les paramètres GET
    if (isset($_GET['action']) && $_GET['action'] == 'modifierProprietaireHandler') {
        // Récupérer les données JSON envoyées depuis le client
        $jsonData = isset($_GET['jsonData']) ? $_GET['jsonData'] : null;
        // Décoder les données JSON
        $data = json_decode($jsonData, true);

        // Récupérer le numéro du demandeur connecté depuis la session
        $num_proprietaire_connecte = isset($_SESSION['numero_prop']) ? intval($_SESSION['numero_prop']) : null;

        // Création d'une instance de la classe proprietaire
        $proprietaire = new proprietaire(); // Assurez-vous que le nom de la classe est correct

        // Récupérer les données du tableau $data au lieu de $_POST
        $nouveauNom = isset($data['nouveauNom']) ? $data['nouveauNom'] : null;
        $nouveauPrenom = isset($data['nouveauPrenom']) ? $data['nouveauPrenom'] : null;
        $nouvelleAdresse = isset($data['nouvelleAdresse']) ? $data['nouvelleAdresse'] : null;
        $nouveauCodePostal = isset($data['nouveauCodePostal']) ? $data['nouveauCodePostal'] : null;
        $nouveauTelephone = isset($data['nouveauTelephone']) ? $data['nouveauTelephone'] : null;
        $nouveauLogin = isset($data['nouveauLogin']) ? $data['nouveauLogin'] : null;

        // Appeler la méthode modifierPropriétaire avec les données récupérées
        $proprietaire->modifierPropriétaire($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $nouveauLogin, $num_proprietaire_connecte);

        // Afficher les paramètres reçus pour le débogage
        echo "Paramètres reçus dans le contrôleur : ";
        var_dump($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $nouveauLogin, $num_proprietaire_connecte);
    }
}

// Appel de la fonction si elle est directement demandée
modifierProprietaireHandler();
?>
