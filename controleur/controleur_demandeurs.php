<?php

include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_visite.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$demandeurs = new demandeurs();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si le formulaire d'inscription est soumis
    if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
        inscription($demandeurs, $errors);
    }
    // Si le formulaire de connexion est soumis
    elseif (isset($_POST['action']) && $_POST['action'] === 'connexion') {
        connexion($demandeurs, $errors);
    }
}
// Si une action est spécifiée dans l'URL
elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
    // Vérifier si l'action est pour afficher les informations du demandeur
    if ($action === 'afficher_infos_demandeur' && isset($_GET['num_demandeur'])) {
        afficherInfosDemandeur($_GET['num_demandeur'], $demandeurs);
    }
}
function getVisitesByDemandeur($num_demandeur) {
    try {
        $visite = new Visite(); // Créer une instance de la classe Visite
        return $visite->getVisitesByDemandeur($num_demandeur);
    } catch (PDOException $e) {
        // Gérer les erreurs PDO si nécessaire
        echo "Erreur PDO : " . $e->getMessage();
        return false;
    }
}

function afficherInfosDemandeur($numDemandeur, $demandeurs) {
    // Récupérer les informations du demandeur
    $demandeur = new Demandeurs();
    $infosDemandeur = $demandeurs->getDemandeurById($numDemandeur);

    // Formattez les informations du demandeur pour l'affichage
    $infosFormatees = "Nom : " . $infosDemandeur['nom_demandeur'] . "\n";
    $infosFormatees .= "Prénom : " . $infosDemandeur['prenom_demandeur'] . "\n";
    $infosFormatees .= "Adresse : " . $infosDemandeur['adresse_demandeur'] . "\n";
    $infosFormatees .= "Code postal : " . $infosDemandeur['cp_demandeur'] . "\n";
    $infosFormatees .= "Téléphone : " . $infosDemandeur['tel_demandeur'] . "\n";
    $infosFormatees .= "Login : " . $infosDemandeur['login'] . "\n";

    // Afficher les informations du demandeur
    echo $infosFormatees;
}

function inscription($demandeurs, &$errors) {
    if ($demandeurs->loginExiste($_POST['login'])) {
        $errors[] = "Ce login est déjà utilisé. Veuillez choisir un autre login.";
        redirigerAvecErreurs($errors);
        return;
    }
    // Vérifier les champs vides
    if (champsVides($_POST)) {
        $errors[] = "Tous les champs doivent être remplis.";
    }
    // Vérifier les champs nom_demandeur et prenom_demandeur
    if (!champsNomPrenomValides($_POST)) {
        $errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
    }
    // Vérifier les champs cp_demandeur et tel_demandeur
    if (!champsCpTelValides($_POST)) {
        $errors[] = "Les champs code postal et téléphone ne doivent contenir que des chiffres.";
    }

    // Si des erreurs sont présentes, rediriger vers le formulaire avec les erreurs
    if (!empty($errors)) {
        redirigerAvecErreurs($errors);
    } else {
        // Procéder au traitement de l'inscription
        $demandeur = new demandeurs(
            $_POST['nom_demandeur'],
            $_POST['prenom_demandeur'],
            $_POST['adresse_demandeur'],
            $_POST['cp_demandeur'],
            $_POST['tel_demandeur'],
            $_POST['login'],
            $_POST['motdepasse_demandeur']
        );

        if ($demandeur->inscription()) {
            demarrerSession($demandeur->getlogin(), $demandeur->getnum_demandeur());
            redirigerVersAccueilDemandeur();
        } else {
            $errors[] = "Erreur lors de l'inscription du demandeur.";
            redirigerAvecErreurs($errors);
        }
    }
}

function connexion($demandeurs, &$errors) {
    $login = $_POST['login'];
    $motdepasse_demandeur = $_POST['motdepasse_demandeur'];
    $num_demandeur = $demandeurs->connexion($login, $motdepasse_demandeur);

    if ($num_demandeur) {
        // La connexion a réussi, démarrer la session et rediriger vers l'accueil
        demarrerSession($login, $num_demandeur);
        redirigerVersAccueilDemandeur();
    } else {
        // Sinon, afficher un message d'erreur et rediriger vers la page de connexion
        $errors[] = "Échec de l'authentification. Vérifiez vos informations de connexion.";
        redirigerAvecErreurs($errors);
    }
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

function champsVides($postData) {
    return empty($postData['nom_demandeur']) || empty($postData['prenom_demandeur']) || empty($postData['adresse_demandeur']) || empty($postData['cp_demandeur']) || empty($postData['tel_demandeur']) || empty($postData['login']) || empty($postData['motdepasse_demandeur']);
}

function champsNomPrenomValides($postData) {
    return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $postData['nom_demandeur']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $postData['prenom_demandeur']);
}

function champsCpTelValides($postData) {
    return preg_match("/^\d+$/", $postData['cp_demandeur']) && preg_match("/^\d+$/", $postData['tel_demandeur']);
}

function redirigerAvecErreurs($errors) {
    $errorString = implode("&", array_map(function($error) {
        return "error[]=" . urlencode($error);
    }, $errors));

    header("Location: ../vue/vue_inscription_demandeur.php?" . $errorString);
    exit();
}
?>
