<?php
session_start();
include_once '..\modele\modele_proprietaire.php';

class InscriptionProprietaireController {
    private $errors = [];

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier les champs vides
            if ($this->champsVides()) {
                $this->errors[] = "Tous les champs doivent être remplis.";
            }
            // Vérifier les champs nom_prop et prenom_prop
            if (!$this->champsNomPrenomValides()) {
                $this->errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
            }
            // Vérifier les champs cp_prop et tel_prop
            if (!$this->champsCpTelValides()) {
                $this->errors[] = "Les champs code postal et téléphone ne doivent contenir que des chiffres.";
            }

            // Si des erreurs sont présentes, afficher les erreurs
            if (!empty($this->errors)) {
                $this->redirigerAvecErreurs();
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
                    $this->confirmation = "Inscription réussie!";
                    $this->redirigerVersAccueilPro();
                } else {
                    $this->confirmation = "Erreur lors de l'inscription du propriétaire.";
                }
            }
        }
    }

    private function redirigerVersAccueilPro() {
        header('Location: ../vue/v_acceuil_pro.php');
        exit(); // Assurez-vous de terminer le script après la redirection
    }

    private function champsVides() {
        return empty($_POST['nom_prop']) || empty($_POST['prenom_prop']) || empty($_POST['adresse_prop']) || empty($_POST['cp_prop']) || empty($_POST['tel_prop']) || empty($_POST['login_prop']) || empty($_POST['motdepasse_pro']);
    }

    private function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_prop']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_prop']);
    }

    private function champsCpTelValides() {
        return preg_match("/^\d+$/", $_POST['cp_prop']) && preg_match("/^\d+$/", $_POST['tel_prop']);
    }

    private function redirigerAvecErreurs() {
        $errorString = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $this->errors));

        header("Location: ../vue/vue_inscription_proprietaire.php?" . $errorString);
        exit();
    }
}

new InscriptionProprietaireController();
?>
