<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../modele/modele_demande.php';
include_once '../modele/modele_proprietaire.php';
include_once '../modele/modele_app.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si le formulaire d'inscription est soumis
    if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
        inscription();
    }
    // Si le formulaire de connexion est soumis
    elseif (isset($_POST['action']) && $_POST['action'] === 'connexion') {
        connexion();
    }
    // Si le formulaire de suppression est soumis
    elseif (isset($_POST['action']) && $_POST['action'] === 'supprimerProprietaireConnecte') {
        supprimerProprietaireConnecte();
    }
else {
    // Si aucune action de formulaire n'est spécifiée, récupérez le loyer total par propriétaire
    recupererLoyerTotal();
}
}
function getAllAppartementsByProprietaire($numero_prop) {
    try {
        // Appeler la méthode statique de la classe Appartement pour récupérer les appartements du propriétaire
        return Appartement::getAllAppartementsByProprietaire($numero_prop);
    } catch (PDOException $e) {
        // Gérer les exceptions PDO ici (par exemple, en les enregistrant dans un fichier journal)
        return false;
    }
}

function getDemandesByAppartement($num_appt) {
    try {
        // Appeler la méthode statique de la classe Demande pour récupérer les demandes de l'appartement spécifié
        return Demande::getDemandesByAppartement($num_appt);
    } catch (PDOException $e) {
        // Gérer les exceptions PDO ici (par exemple, en les enregistrant dans un fichier journal)
        return [];
    }
}

function getDetailsProprietaire() {
    $proprietaire = new Proprietaire();
    if (isset($_SESSION['numero_prop'])) {
        $numero_prop = $_SESSION['numero_prop'];
        return $proprietaire->getDetailsProprietaireById($numero_prop);
    }
    return [];
}

function inscription() {
    $errors = [];
    $proprietaire = new Proprietaire();

    if ($proprietaire->loginExiste($_POST['login_prop'])) {
        $errors[] = "Ce login est déjà utilisé. Veuillez choisir un autre login.";
        redirigerAvecErreurs($errors);
        return;
    }

    // Vérifier les champs vides
    if (champsVides()) {
        $errors[] = "Tous les champs doivent être remplis.";
    }
    // Vérifier les champs nom_prop et prenom_prop
    if (!champsNomPrenomValides()) {
        $errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
    }
    // Vérifier les champs cp_prop et tel_prop
    if (!champsCpTelValides()) {
        $errors[] = "Les champs code postal et téléphone ne doivent contenir que des chiffres.";
    }
    // Si des erreurs sont présentes, afficher les erreurs
    if (!empty($errors)) {
        redirigerAvecErreurs($errors);
    } else {
        // Si aucune erreur, procéder au traitement de l'inscription
        $proprietaire = new Proprietaire(
            $_POST['nom_prop'],
            $_POST['prenom_prop'],
            $_POST['adresse_prop'],
            $_POST['cp_prop'],
            $_POST['tel_prop'],
            $_POST['login_prop'],
            $_POST['motdepasse_pro']
        );

        if ($proprietaire->inscription()) {
            $_SESSION['login_prop'] = $proprietaire->getLoginProp();
            $_SESSION['numero_prop'] = $proprietaire->getNumeroProp();
            $confirmation = "Inscription réussie!";
            redirigerVersAccueilPro();
        } else {
            $confirmation = "Erreur lors de l'inscription du propriétaire.";
        }
    }
}

function connexion() {
    $login_prop = $_POST['login_prop'];
    $motdepasse_pro = $_POST['motdepasse_pro'];
    $proprietaire = new Proprietaire();

    if ($proprietaire->connexion_prop($login_prop, $motdepasse_pro)) {
        $numero_prop = $proprietaire->getNumeroProp();
        $_SESSION['login_prop'] = $login_prop;
        $_SESSION['numero_prop'] = $numero_prop; // Stockez le numéro du propriétaire dans la session
        redirigerVersAccueilPro();
    } else {
        $errors[] = "Échec de l'authentification. Vérifiez vos informations de connexion.";
        redirigerAvecErreurs($errors);
    }
}

function supprimerProprietaireConnecte() {
    if (isset($_SESSION['numero_prop'])) {
        $numero_prop = $_SESSION['numero_prop'];
        $proprietaire = new Proprietaire();
        $success = $proprietaire->supprimerProprietaire($numero_prop);
        if ($success) {
            session_destroy();
            echo 'success';
            exit;
        } else {
            echo 'error';
            exit;
        }
    }
}

function redirigerVersAccueilPro() {
    header('Location: ../vue/v_acceuil_pro.php');
    exit();
}

function recupererLoyerTotal() {
    $proprietaire = new Proprietaire();
    if (isset($_SESSION['numero_prop'])) {
        $numero_prop = $_SESSION['numero_prop'];
        return $proprietaire->getLoyerTotalParProprietaire($numero_prop);
    }
    return null;
}

function champsVides() {
    return empty($_POST['nom_prop']) || empty($_POST['prenom_prop']) || empty($_POST['adresse_prop']) || empty($_POST['cp_prop']) || empty($_POST['tel_prop']) || empty($_POST['login_prop']) || empty($_POST['motdepasse_pro']);
}

function champsNomPrenomValides() {
    return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_prop']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_prop']);
}

function champsCpTelValides() {
    return preg_match("/^\d+$/", $_POST['cp_prop']) && preg_match("/^\d+$/", $_POST['tel_prop']);
}

function redirigerAvecErreurs($errors) {
    $errorString = implode("&", array_map(function($error) {
        return "error[]=" . urlencode($error);
    }, $errors));

    header("Location: ../vue/vue_inscription_proprietaire.php?" . $errorString);
    exit();
}

?>
