<?php
session_start();

include_once '../modele/modele_loc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'supprimerLocataire') {
        // Assurez-vous que l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $num_loc = $_SESSION['user_id'];

            // Créez une instance de la classe Locataire
            $locataire = new Locataire();

            // Utilisez la méthode supprimerLocataire pour supprimer le locataire
            $success = $locataire->supprimerLocataire($num_loc);

            if ($success) {
                // Déconnectez le locataire après la suppression
                session_destroy();
                echo 'success'; // Envoyez une réponse au client
            } else {
                echo 'Erreur lors de la suppression du locataire.';
            }
        } else {
            echo 'L\'utilisateur n\'est pas connecté.';
        }
    } else {
        echo 'Action non autorisée.';
    }
} else {
    echo 'Méthode non autorisée.';
}
?>
