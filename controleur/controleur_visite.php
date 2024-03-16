<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '..\modele\modele_visite.php';

class VisiteController {
    private $visite;

    public function __construct($donneesVisite = null) {
        if ($donneesVisite !== null) {
            $this->visite = new Visite(
                '?', // id_visite
                $donneesVisite['num_demandeur'],
                $donneesVisite['date_visite'],
                $donneesVisite['num_appt']
            );
        }
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
    public function supprimerVisite($id_visite) {

        try {
            // Créez une instance de la classe Visite
            $visite = new Visite();
            
            // Appelez la fonction pour supprimer la visite
            $resultat = $visite->supprimerVisite($id_visite);
    
            // Envoyez une réponse au client
            echo $resultat ? 'Suppression réussie' : 'Échec de la suppression';
            exit(); // Assurez-vous de terminer le script ici
        } catch (PDOException $e) {
            echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
            return false;
        }
    }
}    

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'deleteVisit') {
        // Récupérez l'identifiant de la visite à supprimer
        $id_visite = $_POST['id_visite'];
        
        // Ajoutez un message de débogage pour vérifier l'action
        echo "Action de suppression de visite détectée. ID de visite : $id_visite";

        // Créez une instance du contrôleur de visite sans passer de données
        $visiteController = new VisiteController(); // Supprimez les données d'initialisation ici
        $visiteController->supprimerVisite($id_visite);
    }
}




?>
