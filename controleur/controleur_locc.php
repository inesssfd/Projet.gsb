<?php
include_once '../controleur/param_connexion.php';
include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_loc.php';
session_start();
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
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le paramètre 'num_appt' est défini
    if (!isset($_POST['num_appt'])) {
        $confirmation = "Erreur : paramètre 'num_appt' non défini dans le formulaire.";
    } else {
        $num_appt_from_form = $_POST['num_appt'];

        // Inscription du locataire
        $locataire = new Locataire(
            $_POST['nom_loc'],
            $_POST['prenom_loc'],
            $_POST['date_nais'],
            $_POST['tel_loc'],
            $_POST['num_bancaire'],
            $_POST['nom_banque'],
            $_POST['cp_banque'],
            $_POST['tel_banque'],
            $_POST['login_loc'],
            $_POST['motdepasse_loc'],
            $num_appt_from_form
        );

        // Inscription du locataire
        $inscription_reussie = $locataire->inscriptionloc();

        if ($inscription_reussie) {
            // Suppression du demandeur connecté
            if (!empty($_SESSION['num_demandeur'])) {
                $demandeur = new demandeurs();
                $suppressionDemandeur = $demandeur->supprimerDemandeur($_SESSION['num_demandeur']);

                // Vérifier si la suppression du demandeur a réussi
                if (!$suppressionDemandeur) {
                    $confirmation = "Erreur lors de la suppression du demandeur.";
                } else {
                    // La suppression a réussi
                    $confirmation = "Inscription du locataire réussie et suppression du demandeur effectuée.";
                }
            }
        } else {
            $confirmation = "Erreur lors de l'inscription du locataire.";
        }

        header('Location: ../vue/v_connexion_loc.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'supprimerLocataire') {
        // Assurez-vous que l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $num_loc = $_SESSION['user_id'];

            // Créez une instance de la classe Locataire
            $locataire = new Locataire();

            // Utilisez la méthode supprimerLocataire pour supprimer le locataire
            $success = $locataire->supprimerLocataire($num_loc);

            if ($success) {
                // Déconnectez le locataire après la suppression
                session_destroy();
                echo 'success'; // Envoyez une réponse au client
            } else {
                echo 'Erreur lors de la suppression du locataire.';
            }
        } else {
            echo 'L\'utilisateur n\'est pas connecté.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'connexion') {
        $login_loc = $_POST['login_loc'];
        $motdepasse_loc = $_POST['motdepasse_loc'];

        // Créer une instance de Locataire
        $locataire = new Locataire();

        // Authentifier le locataire
        if ($locataire->connexion($login_loc, $motdepasse_loc)) {
            // Authentification réussie, démarrer la session et rediriger vers la page d'accueil
            demarrerSession($login_loc, $locataire);
            redirigerVersAccueilLoc();
        } else {
            // Authentification échouée, afficher un message d'erreur
            $confirmation = "Échec de l'authentification. Vérifiez vos informations de connexion.";
            echo $confirmation;
        }
    }
}

// Utilisez $confirmation dans votre vue pour informer l'utilisateur.
?>
