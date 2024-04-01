<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../modele/modele_app.php';

function supprimerAppartement(&$confirmation) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_appt'])) {
        $num_appt = $_POST['num_appt'];
        // Ajoutez un message de débogage pour vérifier si la méthode est appelée
        echo "Le contrôleur de suppression est appelé avec le numéro d'appartement : $num_appt";

        try {
            // Ajoutez d'autres messages de débogage ou de journalisation au besoin

            // Appeler la méthode statique de la classe Appartement pour supprimer l'appartement
            if (Appartement::supprimerAppartement($num_appt)) {
                // Suppression réussie
                $confirmation = "L'appartement a été supprimé avec succès.";
            } else {
                // Erreur lors de la suppression
                $confirmation = "Erreur lors de la suppression de l'appartement.";
            }
        } catch (PDOException $e) {
            // Gérer les exceptions PDO ici
            $confirmation = "Succées de la supression" . $e->getMessage();
        }
    }
}

$confirmation = '';
supprimerAppartement($confirmation);
echo $confirmation;
?>
