<?php
include_once '..\modele\modele_demandeur.php';
session_start();

class InscriptionDemandeursController {
    private $demandeurs;
    private $confirmation = '';

    public function __construct($nom_demandeur, $prenom_demandeur, $adresse_demandeur, $cp_demandeur, $tel_demandeur, $login, $motdepasse_demandeur) {
        $this->demandeurs = new demandeurs($nom_demandeur, $prenom_demandeur, $adresse_demandeur, $cp_demandeur, $tel_demandeur, $login, $motdepasse_demandeur);
    }

    public function traiterInscription() {
        if ($this->demandeurs->inscription()) {
            $_SESSION['login'] = $this->demandeurs->getlogin();
            $_SESSION['num_demandeur'] = $this->demandeurs->getnum_demandeur();
            $this->redirigerVersAccueildemandeur();
            $this->confirmation = "Inscription réussie!";
        } else {
            $this->confirmation = "Erreur lors de l'inscription du demandeur.";
        }
    }
    


    private function redirigerVersAccueildemandeur() {
        header('Location: ../vue/v_acceuil_demandeur.php');
        exit(); // Assurez-vous de terminer le script après la redirection
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier les champs vides
    if (empty($_POST['nom_demandeur']) || empty($_POST['prenom_demandeur']) || empty($_POST['adresse_demandeur']) || empty($_POST['cp_demandeur']) || empty($_POST['tel_demandeur']) || empty($_POST['login']) || empty($_POST['motdepasse_demandeur'])) {
        echo "Tous les champs doivent être remplis.";
        exit();
    }

    $controller = new InscriptionDemandeursController(
        $_POST['nom_demandeur'],
        $_POST['prenom_demandeur'],
        $_POST['adresse_demandeur'],
        $_POST['cp_demandeur'],
        $_POST['tel_demandeur'],
        $_POST['login'],
        $_POST['motdepasse_demandeur']
    );
    
    $controller->traiterInscription();
    echo "Données avant l'insertion : ";
    var_dump($controller);
    // Afficher les données du formulaire et la confirmation
    echo "Données du formulaire : <br>";
    echo "Nom : " . $_POST['nom_demandeur'] . "<br>";
    echo "Prénom : " . $_POST['prenom_demandeur'] . "<br>";
    echo "Adresse : " . $_POST['adresse_demandeur'] . "<br>";
    echo "Code Postal : " . $_POST['cp_demandeur'] . "<br>";
    echo "Téléphone : " . $_POST['tel_demandeur'] . "<br>";
    echo "Login : " . $_POST['login'] . "<br>";
    echo "motdepasse_demandeur : " . $_POST['motdepasse_demandeur'] . "<br>";
    
    echo "Confirmation : " . $controller->getConfirmation();
    
return true;
}
?>
