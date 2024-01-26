<?php
include_once '../modele/modele_app.php';
session_start();

class AjoutAppartementController {
    private $confirmation = '';

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->ajouterAppartement();
        }
    }

    private function ajouterAppartement() {
        $num_appt=$_POST['num_appt'];
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

        $appartement = new Appartement($num_appt,$type_appt, $prix_loc, $prix_charge, $rue, $arrondisement, $etage, $ascenseur, $preavis, $date_libre, $numero_prop);

        if ($appartement->ajouterAppartement()) {
            header('Location: ../vue/v_acceuil_pro.php');
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            $this->confirmation = "Erreur lors de l'ajout de l'appartement.";
        }
    }

    public function getConfirmation() {
        return $this->confirmation;
    }
}

$controller = new AjoutAppartementController();
echo $controller->getConfirmation();
?>
