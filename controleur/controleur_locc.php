<?php
include_once '../controleur/param_connexion.php';
include_once '../modele/modele_demandeur.php';
include_once '../modele/modele_loc.php';
session_start();

class InscriptionLocataireController {
    private $locataire;
    private $confirmation = '';
    private $errors = [];

    public function __construct($nom_loc, $prenom_loc, $date_nais, $tel_loc, $num_bancaire, $nom_banque, $cp_banque, $tel_banque, $login_loc, $motdepasse_loc, $num_appt) {
        $this->locataire = new Locataire($nom_loc, $prenom_loc, $date_nais, $tel_loc, $num_bancaire, $nom_banque, $cp_banque, $tel_banque, $login_loc, $motdepasse_loc, $num_appt);
    }

    private function gererErreurNumApptNonDefini() {
        $this->confirmation = "Erreur : paramètre 'num_appt' non défini dans le formulaire.";
        $this->redirigerAvecErreurs([$this->confirmation]);
    }

    public function traiterInscription() {
        if (!$this->champsCpTelValides()) {
            // Gérer l'erreur pour les champs CP et Téléphones
            $this->errors[] = "Les champs des telephones, code postal et des numeros  ne doivent contenir que des chiffres.";
            $this->redirigerAvecErreurs($this->errors);
            return;
        }
        if (!$this->champsNomPrenomValides()) {
            // Gérer l'erreur pour les champs Nom et Prénom
            $this->errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
            $this->redirigerAvecErreurs($this->errors);
            return;
        } else {
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
        }
    }
    
    
    private function redirigerVersAccueilLoc() {
        header('Location: ../vue/v_acceuil_loc.php');
        exit();
    }

    public function getConfirmation() {
        return $this->confirmation;
    }

    private function champsCpTelValides() {
        return preg_match("/^\d+$/", $_POST['tel_loc']) && preg_match("/^\d+$/", $_POST['num_bancaire'])&& preg_match("/^\d+$/", $_POST['cp_banque'])&& preg_match("/^\d+$/", $_POST['tel_banque']);
    }
    private function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_loc']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_loc']);
    }

    private function redirigerAvecErreurs() {
        $errorString = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $this->errors));

        header("Location: ../vue/formulaire_location.php?" . $errorString);
        exit();
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
    }
}

// Utilisez $confirmation dans votre vue pour informer l'utilisateur.
?>
