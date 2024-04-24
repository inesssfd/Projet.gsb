<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Inclure la classe de demande et autres fichiers nécessaires
include_once '..\controleur\param_connexion.php';
include_once '..\modele\modele_demande.php';
include_once '..\modele\modele_demandeur.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $num_appt = $_POST['num_appt'];
    $date_demande = $_POST['date_demande'];

    // Vérifier si une demande existe déjà pour le même demandeur et le même appartement
    $demande_existante = Demande::getDemandeByDemandeurAndAppt($_SESSION['num_demandeur'], $num_appt);

    // Si une demande existe déjà, afficher un message d'erreur et rediriger l'utilisateur
    if ($demande_existante) {
        echo "Vous avez déjà fait une demande pour cet appartement.";
        // Rediriger l'utilisateur vers une page appropriée
        exit();
    }

    // Créer un objet demande avec les données du formulaire
    $nouvelle_demande = new Demande(null, $_SESSION['num_demandeur'], $num_appt, $date_demande, 'En attente');

    // Insérer la demande dans la base de données
    $nouvelle_demande->insererDemande();

    // Rediriger l'utilisateur vers une page de confirmation ou autre
    header("Location: ../vue/v_acceuil_demandeur.php");
    exit();
}
?>
