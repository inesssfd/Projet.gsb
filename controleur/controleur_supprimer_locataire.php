<?php
session_start();

include_once '../modele/modele_loc.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vue/v_accueil_loc.php'); // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    exit();
}

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données postées
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    // Si l'action est de supprimer le locataire
    if ($action === 'supprimerLocataire') {
        // Créer une instance de la classe Locataire
        $locataire = new Locataire();
        $num_loc = $_SESSION['user_id'];

        // Appeler la fonction de suppression dans la classe Locataire
        $success = $locataire->supprimerLocataire($num_loc);

        // Retourner une réponse JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => $success ? 'success' : 'error']);
    } else {
        // Action non reconnue
        header('Content-Type: application/json');
        echo json_encode(['success' => 'error']);
    }
} else {
    // Rediriger vers la page d'accueil si la requête n'est pas une requête POST
    header('Location: index.php');
    exit();
}
?>
