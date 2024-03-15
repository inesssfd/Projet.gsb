<?php
session_start();
// Inclure la classe de demande et autres fichiers nécessaires
include_once '..\controleur\param_connexion.php';
include_once '..\modele\modele_demande.php';
include_once '..\modele\modele_demandeur.php';
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $num_appt = $_POST['num_appt'];
    $date_demande = $_POST['date_demande'];
    
    // Vous pouvez ajouter d'autres données ici
    
    // Créer un objet demande avec les données du formulaire
    $nouvelle_demande = new Demande(null, $_SESSION['num_demandeur'], $num_appt, $date_demande, 'En attente');

    // Insérer la demande dans la base de données
    $nouvelle_demande->insererDemande();

    // Rediriger l'utilisateur vers une page de confirmation ou autre
    header("Location: ../vue/.php");
    exit();
}
?>
