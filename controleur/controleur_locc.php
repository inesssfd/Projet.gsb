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
    public function authentifier($login_loc, $motdepasse_loc) {
        $authController = new AuthentificationLocataireController();
        $authController->authentifier($login_loc, $motdepasse_loc);
        $this->confirmation = $authController->getConfirmation();
    }
    public function traiterInscription() {
        if (!$this->champsCpTelValides()) {
            $this->errors[] = "Les champs des téléphones, code postal et des numéros ne doivent contenir que des chiffres.";
            $this->redirigerAvecErreurs($this->errors);
            return;
        }
        $date_nais = $_POST['date_nais'];
        if (!$this->ageMinimumValide($date_nais)) {
            $this->redirigerAvecErreurs($this->errors);
            return;
        }
        if (!$this->champsNomPrenomValides()) {
            $this->errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
            $this->redirigerAvecErreurs($this->errors);
            return;
        } else {
            // Inscription du locataire
            $inscription_reussie = $this->locataire->inscription();
    
            if ($inscription_reussie) {
                // Suppression du demandeur connecté
                if (!empty($_SESSION['num_demandeur'])) {
                    $demandeur = new demandeurs();
                    $suppressionDemandeur = $demandeur->supprimerDemandeur($_SESSION['num_demandeur']);
    
                    // Vérifier si la suppression du demandeur a réussi
                    if (!$suppressionDemandeur) {
                        $this->confirmation = "Erreur lors de la suppression du demandeur.";
                    } else {
                        // La suppression a réussi
                        $this->confirmation = "Inscription du locataire réussie et suppression du demandeur effectuée.";
                    }
                }
            } else {
                $this->confirmation = "Erreur lors de l'inscription du locataire.";
            }
    
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
        return preg_match("/^\d+$/", $_POST['tel_loc'])&& preg_match("/^\d+$/", $_POST['cp_banque'])&& preg_match("/^\d+$/", $_POST['tel_banque']);
    }
    private function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_loc']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_loc']);
    }
    public function ageMinimumValide($date_nais, $age_minimum = 18) {
        $date_actuelle = new DateTime();
        $date_naissance = new DateTime($date_nais);
        $difference = $date_naissance->diff($date_actuelle);
        $age = $difference->y; // Récupérer l'âge en années
    
        if ($age < $age_minimum) {
            // Gérer l'erreur pour l'âge insuffisant
            $this->errors[] = "Vous devez avoir au moins $age_minimum ans pour vous inscrire comme locataire.";
            return false;
        }
        return true;
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

    // Vérifiez si le formulaire de connexion est soumis
    if (isset($_POST['action']) && $_POST['action'] === 'connexion_locataire') {
        $login_loc = $_POST['login_loc'];
        $motdepasse_loc = $_POST['motdepasse_loc'];

        // Créez une instance de InscriptionLocataireController
        $inscriptionLocataireController = new InscriptionLocataireController();

        // Appelez la méthode d'authentification dans InscriptionLocataireController
        $inscriptionLocataireController->authentifier($login_loc, $motdepasse_loc);

        // Récupérez la confirmation et affichez-la dans votre vue
        $confirmation = $inscriptionLocataireController->getConfirmation();
    }
}

// Utilisez $confirmation dans votre vue pour informer l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'supprimerLocataire') {
        // Assurez-vous que l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $num_loc = $_SESSION['user_id'];

            // Créez une instance de la classe Locataire
            $locataire = new Locataire();

            // Utilisez la méthode supprimerLocataire pour supprimer le locataire
            $success = $locataire->supprimerLocataire($num_loc);

            if ($success) {
                // Déconnectez le locataire après la suppression
                session_destroy();
                echo 'success'; // Envoyez une réponse au client
            } else {
                echo 'Erreur lors de la suppression du locataire.';
            }
        } else {
            echo 'L\'utilisateur n\'est pas connecté.';
        }
    }
    if (isset($_POST['action']) && $_POST['action'] === 'connexion_locataire') {
        // Vérifier si les champs requis sont remplis
        if (isset($_POST['login_loc'], $_POST['motdepasse_loc'])) {
            $login_loc = $_POST['login_loc'];
            $motdepasse_loc = $_POST['motdepasse_loc'];
    
            // Instancier le contrôleur de l'inscription du locataire
            $inscriptionLocataireController = new InscriptionLocataireController();
    
            // Appeler la méthode d'authentification du locataire
            $inscriptionLocataireController->authentifier($login_loc, $motdepasse_loc);
    
            // Récupérer la confirmation
            $confirmation = $inscriptionLocataireController->getConfirmation();
    
            // Utiliser $confirmation dans votre vue pour informer l'utilisateur
            // par exemple, vous pouvez afficher un message de confirmation ou d'erreur
            echo $confirmation;
        } else {
            // Afficher un message d'erreur si les champs requis ne sont pas remplis
            echo "Veuillez remplir tous les champs requis.";
        }
    }
}

// Utilisez $confirmation dans votre vue pour informer l'utilisateur.
?>
