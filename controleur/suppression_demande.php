<?php
session_start();

// Inclure la classe de demande et autres fichiers nécessaires
include_once '..\controleur\param_connexion.php';
include_once '../modele/modele_demande.php';


// Vérifier si la méthode HTTP est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_demandes_location'])) {
    // Récupérer l'ID de la demande à supprimer depuis le formulaire
    $id_demandes_location = $_POST['id_demandes_location'];

    // Supprimer la demande de la base de données
    if (supprimerDemande($id_demandes_location)) {
        echo "La demande a été supprimée avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la suppression de la demande.";
    }
}

// Fonction pour supprimer une demande
function supprimerDemande($id_demandes_location) {
    try {
        // Créer une instance de la classe Demande
        $demande = new demande();
        
        // Appeler la méthode pour supprimer la demande
        return $demande->supprimeDemande($id_demandes_location);
    } catch (PDOException $e) {
        // Gérer les exceptions PDO ici (par exemple, en les enregistrant dans un fichier journal)
        return false;
    }
}
?>
