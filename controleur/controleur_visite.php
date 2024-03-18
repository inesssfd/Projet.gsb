<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '..\modele\modele_visite.php';

class VisiteController {
    private $visite;
    private $errors = []; // Variable pour stocker les erreurs


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
            // Vérifier si la date de visite est ultérieure à la date actuelle
            $date_visite = $this->visite->getDateVisite();
            $date_actuelle = date('Y-m-d');
            
            if ($date_visite < $date_actuelle) {
                // Si la date de visite est antérieure à la date actuelle, afficher une erreur
                $this->redirigerAvecErreurDateVisite("La date de visite doit être ultérieure à la date actuelle.");
                return;
            }
            
            
            // Si la date de visite est valide, procéder au traitement de la visite
            if ($this->visite->visiter()) {
                // Rediriger vers une autre page si le traitement réussit
                header('Location:../vue/appartement_loué.php');
                exit;
            } else {
                // Si le traitement échoue, afficher l'erreur sur la même page
                $this->errors[] = "Erreur lors de l'ajout de la visite.";
                $this->afficherErreurs(); // Appel à la méthode pour afficher les erreurs
            }
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            $this->errors[] = "Erreur PDO : " . $e->getMessage();
            $this->afficherErreurs(); // Appel à la méthode pour afficher les erreurs
        } catch (Exception $e) {
            // Gestion des autres erreurs PHP
            $this->errors[] = "Erreur PHP : " . $e->getMessage();
            $this->afficherErreurs(); // Appel à la méthode pour afficher les erreurs
        }
    }
    private function redirigerAvecErreurDateVisite($errorMessage) {
        $errorString = "date_visite_error=" . urlencode($errorMessage);
        header("Location: ../vue/v_acceuil_demandeur.php?" . $errorString);
        exit();
    }
    
public function modifierDateVisite($id_visite, $nouvelle_date) {
    try {
        // Créez une instance de la classe Visite
        $visite = new Visite();
        
        // Appelez la fonction pour mettre à jour la date de visite
        $resultat = $visite->updateDateVisite($id_visite, $nouvelle_date);

        // Envoyez une réponse au client
        echo $resultat ? 'Mise à jour réussie' : 'Échec de la mise à jour';
        exit(); // Assurez-vous de terminer le script ici
    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
        return false;
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
