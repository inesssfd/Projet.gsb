<?php
include_once '../modele/modele_proprietaire.php';
session_start();

class ConnexionProprietaireController {
    private $proprietaire;

    public function __construct() {
        $this->proprietaire = new Proprietaire();
    }

    public function traiterConnexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login_prop = $_POST['login_prop'];
            $motdepasse_pro = $_POST['motdepasse_pro'];

            if ($this->proprietaire->connexion_prop($login_prop, $motdepasse_pro)) {
                $numero_prop = $this->proprietaire->getNumeroProp();
                $_SESSION['login_prop'] = $login_prop;
                $_SESSION['numero_prop'] = $numero_prop; // Stockez le numéro du propriétaire dans la session
                $this->redirigerVersAccueilPro();
            } else {
                echo "Échec de l'authentification. Vérifiez vos informations de connexion.";
            }
        }
    }

    private function redirigerVersAccueilPro() {
        header('Location: ../vue/v_acceuil_pro.php');
        exit();
    }
}

$controller = new ConnexionProprietaireController();
$controller->traiterConnexion();
?>
