<?php
session_start();
include_once '../modele/modele_loc.php';

// Fonction pour authentifier le locataire
function authentifierLocataire($login_loc, $motdepasse_loc) {
    $locataire = new Locataire();
    if ($locataire->connexion($login_loc, $motdepasse_loc)) {
        demarrerSession($login_loc, $locataire);
        redirigerVersAccueilLoc();
    } else {
        return "Échec de l'authentification. Vérifiez vos informations de connexion.";
    }
}

// Fonction pour démarrer la session
function demarrerSession($login_loc, $locataire) {
    $_SESSION['login_loc'] = $login_loc;
    // Appeler la méthode pour obtenir l'ID de l'utilisateur et le stocker dans la session
    $userId = $locataire->getIdByLogin($login_loc);
    $_SESSION['user_id'] = $userId;
}

// Fonction pour rediriger vers la page d'accueil locataire
function redirigerVersAccueilLoc() {
    header('Location:../vue/v_acceuil_loc.php'); // Assurez-vous de spécifier le chemin correct
    exit();
}


// Vérifier si la requête est une méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_loc = $_POST['login_loc'];
    $motdepasse_loc = $_POST['motdepasse_loc'];

    $confirmation = authentifierLocataire($login_loc, $motdepasse_loc);

    echo $confirmation;
}
?>
