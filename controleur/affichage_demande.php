<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifier si l'utilisateur est connecté en tant que demandeur
if (!isset($_SESSION['num_demandeur']) && !isset($_SESSION['numero_prop'])) {
    // Redirection vers la page de connexion
    header("Location: ../index.php");
    exit;
}
include_once '../modele/modele_demandeur.php';
// Inclure les fichiers nécessaires
include_once '../modele/modele_demande.php';
include_once '../controleur/controleur_visite.php';

// Récupérer le numéro du demandeur connecté depuis la session
$num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

// Récupérer le profil du demandeur connecté
$profil_demandeur = (new demandeurs())->getDemandeurById($num_demandeur_connecte);

// Récupérer les demandes réalisées par le demandeur connecté
$demandes = demande::getDemandesByDemandeur($num_demandeur_connecte);

// Inclure la vue
include_once '../vue/appartement_loué.php';
?>
