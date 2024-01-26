<?php
session_start();
include_once '../modele/modele_demandeur.php';

class AuthentificationDemandeurController {
    private $demandeurs;

    public function __construct() {
        $this->demandeurs = new demandeurs();
    }

    public function authentifier($login, $motdepasse_demandeur) {
        $num_demandeur = $this->demandeurs->connexion($login, $motdepasse_demandeur);
        
        if ($num_demandeur) {
            $this->demarrerSession($login, $num_demandeur);
            $this->redirigerVersAccueilDemandeur();
        } else {
            $this->afficherErreurAuthentification();
        }
    }

    private function demarrerSession($login, $num_demandeur) {
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['num_demandeur'] = $num_demandeur;
    }


    private function redirigerVersAccueilDemandeur() {
        header('Location:../vue/v_acceuil_demandeur.php');
        exit();
    }

    private function afficherErreurAuthentification() {
        echo "Échec de l'authentification. Vérifiez vos informations de connexion.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $motdepasse_demandeur = $_POST['motdepasse_demandeur'];

    $authController = new AuthentificationDemandeurController();
    $authController->authentifier($login, $motdepasse_demandeur);
}
?>
