<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../modele/modele_loc.php';

class LocataireController {
    private $locataire;
    private $errors = [];

    public function __construct() {
        $this->locataire = new Locataire();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
                $this->inscription();
            }
            // Ajoutez d'autres méthodes de traitement des formulaires si nécessaire
        }
    }

    public function getDetailsLocataire() {
        if (isset($_SESSION['numero_loc'])) {
            $numero_loc = $_SESSION['numero_loc'];
            return $this->locataire->getDetailsLocataireById($numero_loc);
        }
        return [];
    }

    private function inscription() {
        if ($this->champsVides()) {
            $this->errors[] = "Tous les champs doivent être remplis.";
        }

        if (!$this->champsNomPrenomValides()) {
            $this->errors[] = "Les champs nom et prénom ainsi que le nom de la banque ne doivent contenir que des lettres et des espaces.";
        }

        if (!$this->champsCpTelValides()) {
            $this->errors[] = "Les champs code postal et téléphone aisni que Numéro de compte bancaire ne doivent contenir que des chiffres.";
        }

        if (!empty($this->errors)) {
            $this->redirigerAvecErreurs();
        } else {
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
                $_POST['motdepasse_loc']
            );

            if ($locataire->inscription()) {
                $_SESSION['login_loc'] = $locataire->getLoginLoc();
                $_SESSION['numero_loc'] = $locataire->getNumeroLoc();
                $this->confirmation = "Inscription réussie!";
                $this->redirigerVersAccueilLoc();
            } else {
                $this->confirmation = "Erreur lors de l'inscription du locataire.";
            }
        }
    }

    // Implémentez d'autres méthodes nécessaires ici

    private function champsVides() {
        return empty($_POST['nom_loc']) || empty($_POST['prenom_loc']) || empty($_POST['date_nais']) || empty($_POST['tel_loc']) || empty($_POST['num_bancaire']) || empty($_POST['nom_banque']) || empty($_POST['cp_banque']) || empty($_POST['tel_banque']) || empty($_POST['login_loc']) || empty($_POST['motdepasse_loc']);
    }

    private function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_loc']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_loc']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_banque']);
    }

    private function champsCpTelValides() {
        return preg_match("/^\d+$/", $_POST['cp_banque']) && preg_match("/^\d+$/", $_POST['tel_loc']) && preg_match("/^\d+$/", $_POST['tel_banque'])&& preg_match("/^\d+$/", $_POST['num_bancaire']);
    }

    private function redirigerAvecErreurs() {
        $errorString = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $this->errors));

        header("Location: ../vue/formulaire_location.php?" . $errorString);
        exit();
    }

    private function redirigerVersAccueilLoc() {
        header('Location: ../vue/v_acceuil_loc.php');
        exit();
    }
}

new LocataireController();
?>
