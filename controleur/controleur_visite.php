<?php
session_start();
include_once '..\modele\modele_visite.php';

class VisiteController {
    private $visite;

    public function __construct($donneesVisite) {
        $this->visite = new Visite(
            '?', // id_visite
            $donneesVisite['num_demandeur'],
            $donneesVisite['date_visite'],
            $donneesVisite['num_appt']
        );
    }

    public function traiterVisite() {
        try {
            if ($this->visite->visiter()) {
                header('Location:../vue/appartement_loué.php');
                exit;
            } else {
                echo "Erreur lors de l'ajout de la visite.";
            }
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur PHP : " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Assurez-vous d'avoir les données nécessaires du formulaire
        var_dump($_POST); // Ajoutez cette ligne pour déboguer
        $donneesVisite = array(
            'num_demandeur' => isset($_POST['num_demandeur']) ? intval($_POST['num_demandeur']) : 0,
            'date_visite' => $_POST['date_visite'],
            'num_appt' => isset($_POST['num_appt']) ? intval($_POST['num_appt']) : 0
        );

        // Output the values for debugging
        echo "Debug - num_demandeur: " . $donneesVisite['num_demandeur'] . "<br>";
        echo "Debug - date_visite: " . $donneesVisite['date_visite'] . "<br>";
        echo "Debug - num_appt: " . $donneesVisite['num_appt'] . "<br>";

        // Créez une instance de la classe VisiteController et traitez la visite
        $visiteController = new VisiteController($donneesVisite);
        $visiteController->traiterVisite();

    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
        return false;
    }
}
?>
