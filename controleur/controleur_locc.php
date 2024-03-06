<?php
include_once '../controleur/param_connexion.php';
include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_loc.php';
session_start();

class InscriptionLocataireController {
    private $locataire;
    private $confirmation = '';

    public function __construct($nom_loc, $prenom_loc, $date_nais, $tel_loc, $num_bancaire, $nom_banque, $cp_banque, $tel_banque, $login_loc, $motdepasse_loc, $num_appt) {
        $this->locataire = new Locataire($nom_loc, $prenom_loc, $date_nais, $tel_loc, $num_bancaire, $nom_banque, $cp_banque, $tel_banque, $login_loc, $motdepasse_loc, $num_appt);
    }

    public function traiterInscription() {
        // Vérifier si l'inscription du locataire est réussie
        if ($this->locataire->inscription()) {
            $_SESSION['login_loc'] = $this->locataire->getLoginLoc();
            
    
            // Supprimer le demandeur connecté après la redirection
            if (!empty($_SESSION['num_demandeur'])) {
                $demandeur = new demandeurs();
                $suppressionDemandeur = $demandeur->supprimerDemandeur($_SESSION['num_demandeur']);
                
                // Vérifier si la suppression du demandeur a réussi
                if (!$suppressionDemandeur) {
                    $this->confirmation = "Erreur lors de la suppression du demandeur.";
                } else {
                    // La suppression a réussi, vous pouvez ajouter un message de confirmation si nécessaire
                    $this->confirmation = "Inscription du locataire réussie et suppression du demandeur effectuée.";
                }
            }
    
            // Vous pouvez commenter ou supprimer la ligne suivante si vous ne souhaitez pas rediriger
            $this->redirigerVersAccueilLoc();
        } else {
            $this->confirmation = "Erreur lors de l'inscription du locataire.";
        }
    }
    
    private function redirigerVersAccueilLoc() {
        header('Location: ../vue/v_connexion_loc.php');
        exit();
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le paramètre 'num_appt' est défini
    if (isset($_POST['num_appt'])) {
        $num_appt_from_form = $_POST['num_appt'];
    } else {
        $confirmation = "Erreur : paramètre 'num_appt' non défini dans le formulaire.";
    }

    if (isset($num_appt_from_form)) {
        $controller = new InscriptionLocataireController(
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

        $controller->traiterInscription();
        $confirmation = $controller->getConfirmation();

        // Supprimer la session du demandeur si elle existe
        if (!empty($_SESSION['num_demandeur'])) {
            unset($_SESSION['num_demandeur']);
        }
    }
}

// Utilisez $confirmation dans votre vue pour informer l'utilisateur.
?>
