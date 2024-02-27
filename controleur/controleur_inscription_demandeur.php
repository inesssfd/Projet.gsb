<?php
session_start();
include_once '..\modele\modele_demandeur.php';

class InscriptionDemandeurController {
    private $errors = [];

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                // Si aucune erreur, procéder au traitement de l'inscription
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
                    $_SESSION['login'] = $demandeur->getlogin();
                    $_SESSION['num_demandeur'] = $demandeur->getnum_demandeur();
                    $this->redirigerVersAccueildemandeur();
                    $this->confirmation = "Inscription réussie!";
                } else {
                    $this->confirmation = "Erreur lors de l'inscription du demandeur.";
                }
            }
        }
    }

    private function redirigerVersAccueildemandeur() {
        header('Location: ../vue/v_acceuil_demandeur.php');
        exit(); // Assurez-vous de terminer le script après la redirection
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

new InscriptionDemandeurController();
?>
