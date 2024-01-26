<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once '../modele/modele_app.php';

// Vérifier si le formulaire de modification a été soumis
if (isset($_GET['action']) && $_GET['action'] === 'modifierAppartement') {
    // Récupérer les données POST
    $num_prop = $_POST['num_prop'];
    $num_appt = $_POST['num_appt'];
    $nouveauType = $_POST['nouveauType'];
    $nouveauPrix = $_POST['nouveauPrix'];
    $nouvelleCharge = $_POST['nouvelleCharge'];
    $nouvelleRue = $_POST['nouvelleRue'];

    // Appeler la méthode pour modifier l'appartement
    $resultat = Appartement::modifierAppartement($num_appt, $nouveauType, $nouveauPrix, $nouvelleCharge, $nouvelleRue, $num_prop);

    // Vérifier le résultat de la modification
    if ($resultat) {
        // Modification réussie
        echo json_encode(['success' => true]);
    } else {
        // Erreur lors de la modification
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification de l\'appartement.']);
    }
} else {
    // Action non valide
    echo json_encode(['success' => false, 'message' => 'Action non valide.']);
}
        ?>