<?php
session_start();
include_once '../modele/modele_demandeur.php';

class DemandeurController {
    private $demandeurs;
    private $errors = [];

    public function __construct() {
        $this->demandeurs = new demandeurs();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si le formulaire d'inscription est soumis
            if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
                $this->inscription();
            }
            // Si le formulaire de connexion est soumis
            elseif (isset($_POST['action']) && $_POST['action'] === 'connexion') {
                $this->connexion();
            }
        }
        // Si une action est spécifiée dans l'URL
        elseif (isset($_GET['action'])) {
            $action = $_GET['action'];
            // Vérifier si l'action est pour afficher les informations du demandeur
            if ($action === 'afficher_infos_demandeur' && isset($_GET['num_demandeur'])) {
                $this->afficherInfosDemandeur($_GET['num_demandeur']);
            }
        }
    }

  public function afficherInfosDemandeur($numDemandeur) {
        // Récupérer les informations du demandeur
        $demandeur = new Demandeurs();
        $infosDemandeur = $demandeur->getDemandeurById($numDemandeur);

        // Formattez les informations du demandeur pour l'affichage
        $infosFormatees = "Nom : " . $infosDemandeur['nom_demandeur'] . "\n";
        $infosFormatees .= "Prénom : " . $infosDemandeur['prenom_demandeur'] . "\n";
        $infosFormatees .= "Adresse : " . $infosDemandeur['adresse_demandeur'] . "\n";
        $infosFormatees .= "Code postal : " . $infosDemandeur['cp_demandeur'] . "\n";
        $infosFormatees .= "Téléphone : " . $infosDemandeur['tel_demandeur'] . "\n";
        $infosFormatees .= "Login : " . $infosDemandeur['login'] . "\n";

        // Afficher les informations du demandeur
        echo $infosFormatees;
    }

    private function inscription() {
        if ($this->demandeurs->loginExiste($_POST['login'])) {
            $this->errors[] = "Ce login est déjà utilisé. Veuillez choisir un autre login.";
            $this->redirigerAvecErreurs();
            return;
        }
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
            // Procéder au traitement de l'inscription
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
                $this->demarrerSession($demandeur->getlogin(), $demandeur->getnum_demandeur());
                $this->redirigerVersAccueilDemandeur();
            } else {
                $this->errors[] = "Erreur lors de l'inscription du demandeur.";
                $this->redirigerAvecErreurs();
            }
        }
    }

    private function connexion() {
        $login = $_POST['login'];
        $motdepasse_demandeur = $_POST['motdepasse_demandeur'];
        $num_demandeur = $this->demandeurs->connexion($login, $motdepasse_demandeur);
    
        if ($num_demandeur) {
            // La connexion a réussi, démarrer la session et rediriger vers l'accueil
            $this->demarrerSession($login, $num_demandeur);
            $this->redirigerVersAccueilDemandeur();
        } else {
            // Sinon, afficher un message d'erreur et rediriger vers la page de connexion
            $this->errors[] = "Échec de l'authentification. Vérifiez vos informations de connexion.";
            $this->redirigerAvecErreurs();
        }
    }
    

    private function demarrerSession($login, $num_demandeur) {
        $_SESSION['login'] = $login;
        $_SESSION['num_demandeur'] = $num_demandeur;
    }

    private function redirigerVersAccueilDemandeur() {
        header('Location: ../vue/v_acceuil_demandeur.php');
        exit();
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
new DemandeurController(); // Instanciation de la classe DemandeurController
?>
