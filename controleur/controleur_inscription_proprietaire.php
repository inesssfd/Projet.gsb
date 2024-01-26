<?php
include_once '..\modele\modele_proprietaire.php';
session_start();

class InscriptionProprietaireController {
    private $proprietaire;
    private $confirmation = '';

    public function __construct($nom_prop, $prenom_prop, $adresse_prop, $cp_prop, $tel_prop, $login_prop, $motdepasse_pro) {
        $this->proprietaire = new Proprietaire($nom_prop, $prenom_prop, $adresse_prop, $cp_prop, $tel_prop, $login_prop, $motdepasse_pro);
    }

    public function traiterInscription() {
        if ($this->proprietaire->inscription()) {
            $_SESSION['login_prop'] = $this->proprietaire->getLoginProp();
            $_SESSION['numero_prop'] = $this->proprietaire->getNumeroProp();
            $this->confirmation = "Inscription réussie!";
            $this->redirigerVersAccueilPro();
        } else {
            $this->confirmation = "Erreur lors de l'inscription du propriétaire.";
        }
        
    }

    private function redirigerVersAccueilPro() {
        header('Location: ../vue/v_acceuil_pro.php');
        exit(); // Assurez-vous de terminer le script après la redirection
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new InscriptionProprietaireController(
        $_POST['nom_prop'],
        $_POST['prenom_prop'],
        $_POST['adresse_prop'],
        $_POST['cp_prop'],
        $_POST['tel_prop'],
        $_POST['login_prop'],
        $_POST['motdepasse_pro']
    );

    $controller->traiterInscription();
    echo $controller->getConfirmation();
}
?>
