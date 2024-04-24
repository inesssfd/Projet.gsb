<?php
// Vérifier si l'action est définie dans la requête
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'updateVisitDate') {
        modifierDateVisite();
    } else {
        // Action non valide
        repondreAvecErreur("Action non valide.");
    }
} else {
    // Action non spécifiée dans la requête
    repondreAvecErreur("Action non spécifiée.");
}

function modifierDateVisite() {
    // Vérifier si les données requises sont présentes
    if (isset($_POST['id_visite']) && isset($_POST['date_visite'])) {
        // Inclure la classe Visite
        include_once '../modele/modele_visite.php';
        
        // Récupérer les données de la requête
        $id_visite = $_POST['id_visite'];
        $nouvelle_date_visite = $_POST['date_visite'];

        // Créer une instance de la classe Visite
        $visite = new Visite();

        // Appeler la méthode pour mettre à jour la date de visite
        $resultat = $visite->modifierDateVisite($id_visite, $nouvelle_date_visite);

        // Vérifier si la mise à jour a réussi
        if ($resultat) {
            // Répondre avec un code de succès
            repondreAvecSucces("La date de visite a été modifiée avec succès.");
        } else {
            // Répondre avec un code d'erreur
            repondreAvecErreur("Erreur lors de la modification de la date de visite.");
        }
    } else {
        // Les données requises ne sont pas présentes
        // Répondre avec un code d'erreur
        repondreAvecErreur("Paramètres manquants dans la requête.");
    }
}

function repondreAvecSucces($message) {
    // Répondre avec un code de succès et le message spécifié
    http_response_code(200);
    echo $message;
    exit;
}

function repondreAvecErreur($message) {
    // Répondre avec un code d'erreur et le message spécifié
    http_response_code(400);
    echo $message;
    exit;
}
?>
