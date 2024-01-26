<?php
session_start();
include_once '../modele/modele_proprietaire.php';
if (isset($_POST['action'])) {
    // Vérifiez quelle action a été soumise
    if ($_POST['action'] === 'supprimerProprietaireConnecte') {
        // Utilisez la fonction supprimerProprietaireConnecte pour supprimer le propriétaire connecté
        supprimerProprietaireConnecte();
        // Envoyez une réponse au client pour indiquer le succès de la suppression
        echo 'success';
        exit; // Assurez-vous de terminer le script après l'envoi de la réponse
    }
}
// Fonction pour obtenir les détails du propriétaire
function getDetailsProprietaire() {
    // Vérifiez si le propriétaire est connecté
    if (isset($_SESSION['numero_prop'])) {
        $numero_prop = $_SESSION['numero_prop'];

        // Créez une instance de la classe proprietaire
        $proprietaire = new proprietaire();

        // Utilisez la méthode getDetailsProprietaireById pour obtenir les détails du propriétaire
        $details_proprietaire = $proprietaire->getDetailsProprietaireById($numero_prop);

        // Vérifiez si les détails du propriétaire ont été récupérés avec succès
        if ($details_proprietaire) {
            // Retournez les détails du propriétaire
            return $details_proprietaire;
        }
    }

    // Retournez un tableau vide en cas d'échec ou si le propriétaire n'est pas connecté
    return [];
}
function supprimerProprietaireConnecte() {
    // Assurez-vous que le propriétaire est connecté
    if (isset($_SESSION['numero_prop'])) {
        $numero_prop = $_SESSION['numero_prop'];

        // Créez une instance de la classe proprietaire
        $proprietaire = new proprietaire();

        // Utilisez la méthode supprimerProprietaire pour supprimer le propriétaire
        $success = $proprietaire->supprimerProprietaire($numero_prop);

        if ($success) {
            // Déconnectez le propriétaire après la suppression (si nécessaire)
            session_destroy();
            // Vous pouvez également rediriger l'utilisateur vers une page spécifique après la suppression
            // header("Location: chemin_vers_page_de_redirection.php");
            // exit;
        } else {
            // Gérez l'échec de la suppression, si nécessaire
            echo "Erreur lors de la suppression du propriétaire.";
        }
    }
}

// Appel de la fonction pour obtenir les détails du propriétaire
$details_proprietaire = getDetailsProprietaire();
?>
