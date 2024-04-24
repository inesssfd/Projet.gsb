<?php
session_start();

include_once '../modele/modele_loc.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: accueil.php'); // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo"c'est bon";
    // Récupérer les données postées
    $nom_loc = $_POST['nom_loc'];
    $prenom_loc = $_POST['prenom_loc'];
    $date_nais = $_POST['date_nais'];
    $tel_loc = $_POST['tel_loc'];
    
    // Créer une instance de la classe Locataire
    $locataire = new Locataire();
    $num_loc = $_SESSION['user_id'];

    // Appeler la fonction de modification dans la classe Locataire
    $success = $locataire->modifierLocataire($num_loc, $nom_loc, $prenom_loc, $date_nais, $tel_loc);

    // Retourner une réponse JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
} else {
    // Rediriger vers la page d'accueil si la requête n'est pas une requête POST
    header('Location: index.php');
    exit();
}
?>
