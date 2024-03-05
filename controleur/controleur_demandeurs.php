<?php
session_start();
include_once '../modele/modele_demandeur.php';

class DemandeurController {
    private $demandeurs;
    private $errors = [];

    public function __construct() {
        $this->demandeurs = new demandeurs();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si le formulaire d'inscription est soumis
            if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
                $this->inscription();
            }
            // Si le formulaire de connexion est soumis
            elseif (isset($_POST['action']) && $_POST['action'] === 'connexion') {
                $this->connexion();
            }
            // Si le formulaire de modification est soumis
            elseif (isset($_POST['action']) && $_POST['action'] === 'modifierDemandeur') {
                $this->modifierDemandeur();
            }
        }
    }

public function modifierDemandeur() {
    // Vérification de l'action dans les paramètres GET
    if (isset($_GET['action']) && $_GET['action'] == 'modifierDemandeur') {
        // Récupérer le numéro du demandeur connecté depuis la session
        $num_demandeur_connecte = isset($_SESSION['num_demandeur']) ? $_SESSION['num_demandeur'] : null;

        $nouveauNom = isset($_POST['nouveauNom']) ? $_POST['nouveauNom'] : null;
        $nouveauPrenom = isset($_POST['nouveauPrenom']) ? $_POST['nouveauPrenom'] : null;
        $nouvelleAdresse = isset($_POST['nouvelleAdresse']) ? $_POST['nouvelleAdresse'] : null;
        $nouveauCodePostal = isset($_POST['nouveauCodePostal']) ? $_POST['nouveauCodePostal'] : null;
        $nouveauTelephone = isset($_POST['nouveauTelephone']) ? $_POST['nouveauTelephone'] : null;

        // Appel de la méthode de modification avec le numéro du demandeur connecté
        $this->demandeur->modifierDemandeur($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_demandeur_connecte);
    }
}

    private function inscription() {
        // Vérifier les champs vides
        if ($this->champsVides()) {
            $this->errors[] = "Tous les champs doivent être remplis.";
        }
        // Vérifier les champs nom_demandeur et prenom_demandeur
        if (!$this->champsNomPrenomValides()) {
            $this->errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
        }
        // Vérifier les champs cp_demandeur et tel_demandeur
        if (!$this->champsCpTelValides()) {
            $this->errors[] = "Les champs code postal et téléphone ne doivent contenir que des chiffres.";
        }

        // Si des erreurs sont présentes, rediriger vers le formulaire avec les erreurs
        if (!empty($this->errors)) {
            $this->redirigerAvecErreurs();
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
                $this->demarrerSession($demandeur->getlogin(), $demandeur->getnum_demandeur());
                $this->redirigerVersAccueilDemandeur();
            } else {
                $this->errors[] = "Erreur lors de l'inscription du demandeur.";
                $this->redirigerAvecErreurs();
            }
        }
    }

    private function connexion() {
        $login = $_POST['login'];
        $motdepasse_demandeur = $_POST['motdepasse_demandeur'];
        $num_demandeur = $this->demandeurs->connexion($login, $motdepasse_demandeur);
    
        if ($num_demandeur) {
            // La connexion a réussi, démarrer la session et rediriger vers l'accueil
            $this->demarrerSession($login, $num_demandeur);
            $this->redirigerVersAccueilDemandeur();
        } else {
            // Sinon, afficher un message d'erreur et rediriger vers la page de connexion
            $this->errors[] = "Échec de l'authentification. Vérifiez vos informations de connexion.";
            $this->redirigerAvecErreurs();
        }
    }
    

    private function demarrerSession($login, $num_demandeur) {
        $_SESSION['login'] = $login;
        $_SESSION['num_demandeur'] = $num_demandeur;
    }

    private function redirigerVersAccueilDemandeur() {
        header('Location: ../vue/v_acceuil_demandeur.php');
        exit();
    }

    private function champsVides() {
        return empty($_POST['nom_demandeur']) || empty($_POST['prenom_demandeur']) || empty($_POST['adresse_demandeur']) || empty($_POST['cp_demandeur']) || empty($_POST['tel_demandeur']) || empty($_POST['login']) || empty($_POST['motdepasse_demandeur']);
    }

    private function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_demandeur']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_demandeur']);
    }

    private function champsCpTelValides() {
        return preg_match("/^\d+$/", $_POST['cp_demandeur']) && preg_match("/^\d+$/", $_POST['tel_demandeur']);
    }

    private function redirigerAvecErreurs() {
        $errorString = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $this->errors));

        header("Location: ../vue/vue_inscription_demandeur.php?" . $errorString);
        exit();
    }

}
new DemandeurController(); // Instanciation de la classe DemandeurController
?>
