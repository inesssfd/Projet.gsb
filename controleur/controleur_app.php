<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../modele/modele_app.php';

class AppartementController {
    private $confirmation = '';

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si le formulaire d'ajout ou de modification est soumis
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'ajouterAppartement') {
                    $this->ajouterAppartement();
                } elseif ($_POST['action'] === 'modifierAppartement') {
                    $this->modifierAppartement();
                }
            }
        }
    }
    public function getConfirmation() {
        return $this->confirmation;
    }
    

    public function rechercherAppartements() {
        $type_appt = isset($_GET['type_appt']) ? $_GET['type_appt'] : '';
        $arrondisement = isset($_GET['arrondisement']) ? $_GET['arrondisement'] : '';
        $prix_loc = isset($_GET['prix_loc']) ? $_GET['prix_loc'] : PHP_INT_MAX;

        // Filtrer les appartements en fonction des critères de recherche
        return Appartement::getFilteredAppartements($type_appt, $arrondisement, $prix_loc);
    }
    private function ajouterAppartement() {
        $num_appt = $_POST['num_appt'];
        $type_appt = $_POST['type_appt'];
        $prix_loc = $_POST['prix_loc'];
        $prix_charge = $_POST['prix_charge'];
        $rue = $_POST['rue'];
        $arrondisement = $_POST['arrondisement'];
        $etage = $_POST['etage'];
        $ascenseur = $_POST['ascenseur'];
        $preavis = $_POST['preavis'];
        $date_libre = $_POST['date_libre'];
        $numero_prop = $_POST['numero_prop'];
    
        $appartement = new Appartement($num_appt, $type_appt, $prix_loc, $prix_charge, $rue, $arrondisement, $etage, $ascenseur, $preavis, $date_libre, $numero_prop);
    
        try {
            if ($appartement->ajouterAppartement()) {
                // Redirection avec un message de succès
                header('Location: ../vue/v_acceuil_pro.php?success=1');
                exit();
            } else {
                // En cas d'échec, stocker le message d'erreur dans la variable de session
                $_SESSION['confirmation'] = "Erreur lors de l'ajout de l'appartement vous avez deja trop d'appartement";
            }
        } catch (PDOException $e) {
            // En cas d'erreur PDO, affichez le message d'erreur spécifique
            $_SESSION['confirmation'] = "Erreur lors de l'ajout de l'appartement : " . $e->getMessage();
        }
    }
    
    
    private function modifierAppartement() {
        // Récupérer les données POST
        $num_prop = $_POST['num_prop'];
        $num_appt = $_POST['num_appt'];
        $nouveauType = $_POST['nouveauType'];
        $nouveauPrix = $_POST['nouveauPrix'];
        $nouvelleCharge = $_POST['nouvelleCharge'];
        $nouvelleRue = $_POST['nouvelleRue'];

        // Appeler la méthode pour modifier l'appartement
        $resultat = Appartement::modifierAppartement($num_appt, $nouveauType, $nouveauPrix, $nouvelleCharge, $nouvelleRue, $num_prop);

        // Vérifier le résultat de la modification
        if ($resultat) {
            // Modification réussie
            $this->confirmation = "L'appartement a été modifié avec succès.";
        } else {
            // Erreur lors de la modification
            $this->confirmation = "Erreur lors de la modification de l'appartement.";
        }
    }

}

$controller = new AppartementController();
echo $controller->getConfirmation();
?>
