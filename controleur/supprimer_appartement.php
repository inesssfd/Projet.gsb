<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../modele/modele_app.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_appt'])) {
    $num_appt = $_POST['num_appt'];

    // Appel de la fonction supprimerAppartement du modèle
    if (Appartement::supprimerAppartement($num_appt)) {
        // Suppression réussie
        $confirmation = "L'appartement a été supprimé avec succès.";
    } else {
        // Erreur lors de la suppression
        $confirmation = "Erreur lors de la suppression de l'appartement.";
    }
}

?>
