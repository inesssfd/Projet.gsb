<?php
session_start();
include_once '../modele/modele_loc.php';

class AuthentificationLocataireController {
    private $locataire;
    private $confirmation = '';

    public function __construct() {
        $this->locataire = new Locataire();
    }

    public function authentifier($login_loc, $motdepasse_loc) {
        if ($this->locataire->connexion($login_loc, $motdepasse_loc)) {
            $this->demarrerSession($login_loc);
            $this->redirigerVersAccueilLoc();
        } else {
            $this->confirmation = "Échec de l'authentification. Vérifiez vos informations de connexion.";
        }
    }

    private function demarrerSession($login_loc) {
        $_SESSION['login_loc'] = $login_loc;
    
        // Call the method to get the user ID and store it in the session
        $userId = $this->locataire->getIdByLogin($login_loc);
        $_SESSION['user_id'] = $userId;
    }
    

    private function redirigerVersAccueilLoc() {
        header('Location:..\vue\v_acceuil_loc.php'); // Assurez-vous de spécifier le chemin correct
        exit();
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_loc = $_POST['login_loc'];
    $motdepasse_loc = $_POST['motdepasse_loc'];

    $authController = new AuthentificationLocataireController();
    $authController->authentifier($login_loc, $motdepasse_loc);

    echo $authController->getConfirmation();
}
?>
