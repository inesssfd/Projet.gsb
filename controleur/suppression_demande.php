<?php
include_once '../modele/modele_demande.php'; // Inclure la classe de demande

// Vérifier si l'ID de la demande a été envoyé via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_demandes_location"])) {
    // Récupérer l'ID de la demande à supprimer depuis le formulaire
    $id_demandes_location = $_POST["id_demandes_location"];

    // Appeler la méthode statique pour supprimer la demande
    $suppression_reussie = Demande::supprimeDemande($id_demandes_location);

    // Vérifier si la suppression a réussi
    if ($suppression_reussie) {
        // Retourner une réponse JSON indiquant le succès de la suppression
        echo json_encode(array("success" => true, "message" => "La demande a été supprimée avec succès."));
    } else {
        // Retourner une réponse JSON indiquant l'échec de la suppression
        echo json_encode(array("success" => false, "message" => "La demande n'a pas pu être supprimée."));
    }
} else {
    // Si aucune demande n'a été envoyée via POST, retourner une erreur JSON
    echo json_encode(array("success" => false, "message" => "Aucune demande à supprimer."));
}
?>