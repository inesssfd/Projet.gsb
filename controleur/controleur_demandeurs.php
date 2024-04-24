<?php

include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_visite.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$errors = [];
// Vérifier si l'utilisateur est déjà connecté
if(isset($_SESSION['num_demandeur'])) {
    redirigerVersAccueilDemandeur();
}

function demarrerSession($login, $num_demandeur) {
    $_SESSION['login'] = $login;
    $_SESSION['num_demandeur'] = $num_demandeur;
    // Rediriger vers la page d'accueil du demandeur avec le numéro du demandeur dans l'URL
    header('Location: ../vue/v_acceuil_demandeur.php?num_demandeur=' . $num_demandeur);
    exit();
}

function redirigerVersAccueilDemandeur() {
    header('Location: ../vue/v_acceuil_demandeur.php');
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'inscription') {
    // Initialiser un tableau pour stocker les éventuelles erreurs
    $errors = [];

    // Vérifier que tous les champs requis sont renseignés
    $required_fields = ['nom_demandeur', 'prenom_demandeur', 'adresse_demandeur', 'cp_demandeur', 'tel_demandeur', 'login', 'motdepasse_demandeur'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "Le champ $field est requis.";
        }
    }

    // Si aucun erreur, procéder à l'inscription
    if (empty($errors)) {
        // Créer une nouvelle instance de la classe demandeurs (ou utiliser celle déjà créée)
        $demandeur = new demandeurs();
        $demandeur->setnom_demandeur($_POST['nom_demandeur']);
        $demandeur->setprenom_demandeur($_POST['prenom_demandeur']);
        $demandeur->setadresse_demandeur($_POST['adresse_demandeur']);
        $demandeur->setcp_demandeur($_POST['cp_demandeur']);
        $demandeur->settel_demandeur($_POST['tel_demandeur']);
        $demandeur->setlogin($_POST['login']);
        $demandeur->setmotdepasse_demandeur($_POST['motdepasse_demandeur']);
        if ($demandeur->inscription()) {
            $num_demandeur = $demandeur->getLastInsertId(); // Récupérer le dernier ID inséré
            demarrerSession($_POST['login'], $num_demandeur);
            redirigerVersAccueilDemandeur();
        } else {
            // En cas d'échec de l'inscription, redirigez avec les erreurs
            $demandeur->redirigerAvecErreurs($demandeur->errors); // Passer le tableau d'erreurs comme argument
        }
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'connexion_demandeur') {
    // Tenter de se connecter
    if (empty($_POST['login']) || empty($_POST['motdepasse_demandeur'])) {
        $errors[] = "Le login et le mot de passe sont requis.";
        redirigerAvecErreurs($errors);
    } else {
        // Créer une instance de la classe demandeurs
        $demandeurs = new demandeurs();
        $num_demandeur = $demandeurs->connexion($_POST['login'], $_POST['motdepasse_demandeur']);
        if ($num_demandeur) {
            // Stocker num_demandeur dans la session
            $_SESSION['num_demandeur'] = $num_demandeur;
            // Rediriger vers la page d'accueil
            demarrerSession($_POST['login'], $num_demandeur);
            redirigerVersAccueilDemandeur();

        } else {
            // Échec de l'authentification, rediriger avec un message d'erreur
            $errors[] = "Login ou mot de passe incorrect.";
            redirigerAvecErreurs($errors);
        }
    }

    } else {
        // Rediriger vers la page de connexion si aucune action POST appropriée n'est effectuée
        header('Location: ../vue/vue_connexion_demandeur.php');
        exit();
    }
}
function redirigerAvecErreurs($errors) {
    // Construire la chaîne de requête avec les erreurs
    $errorString = implode("&", array_map(function($error) {
        return "error[]=" . urlencode($error);
    }, $errors));

    // Utiliser la chaîne de requête avec les erreurs dans la redirection
    header("Location: ../vue/vue_inscription_demandeur.php?" . $errorString);
    exit();
}

?>
