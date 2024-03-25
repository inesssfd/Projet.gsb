<?php
// Inclusion du fichier contenant le modèle Admin
include_once '../modele/modele_admin.php';

// Vérification si des données de connexion sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des champs
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // Récupération des données saisies
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Tentative de connexion en utilisant le modèle Admin
        $admin = new Admin();
        $adminData = $admin->login($username, $password);

        // Vérification si la connexion est réussie
        if ($adminData) {
            // Connexion réussie, rediriger vers la page d'accueil de l'administration par exemple
            header("Location: ../vue/administrateur.php");
            exit;
        } else {
            header("Location: ../vue/connexion_admin.php");
        }
    } else {
        // Les champs ne sont pas tous remplis, afficher un message d'erreur
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
