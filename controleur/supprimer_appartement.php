<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../modele/modele_app.php';

class SuppressionController {
    private $confirmation = '';

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supprimerAppartement();
        }
    }
    

    private function supprimerAppartement() {
        if (isset($_POST['num_appt'])) {
            $num_appt = $_POST['num_appt'];
            // Ajoutez un message de débogage pour vérifier si la méthode est appelée
            echo "Le contrôleur de suppression est appelé avec le numéro d'appartement : $num_appt";

            try {
                // Ajoutez d'autres messages de débogage ou de journalisation au besoin

                // Appeler la méthode statique de la classe Appartement pour supprimer l'appartement
                if (Appartement::supprimerAppartement($num_appt)) {
                    // Suppression réussie
                    $this->confirmation = "L'appartement a été supprimé avec succès.";
                } else {
                    // Erreur lors de la suppression
                    $this->confirmation = "Erreur lors de la suppression de l'appartement.";
                }
            } catch (PDOException $e) {
                // Gérer les exceptions PDO ici
                $this->confirmation = "Erreur lors de la suppression de l'appartement : " . $e->getMessage();
            }
        }
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

$suppressionController = new SuppressionController();
echo $suppressionController->getConfirmation();
?>
