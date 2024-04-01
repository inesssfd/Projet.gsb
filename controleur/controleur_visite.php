<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '..\modele\modele_visite.php';

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

        // Création d'une instance de la classe Visite
        $visite = new Visite(
            '?', // id_visite
            $donneesVisite['num_demandeur'],
            $donneesVisite['date_visite'],
            $donneesVisite['num_appt']
        );

        traiterVisite($visite);

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

        // Suppression de la visite
        supprimerVisite($id_visite);
    }
}
function modifierDateVisite($id_visite, $nouvelle_date) {
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

function traiterVisite($visite) {
    try {
        // Vérifier si la date de visite est antérieure à la date actuelle
        $date_visite = $visite->getDateVisite();
        $date_actuelle = date('Y-m-d'); // Obtenez la date actuelle au format 'AAAA-MM-JJ'

        if ($date_visite < $date_actuelle) {
            echo "La date de visite ne peut pas être antérieure à la date actuelle.";
            return; // Arrêtez le traitement de la visite
        }

        // La date de visite est valide, procédez au traitement
        if ($visite->visiter()) {
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

function supprimerVisite($id_visite) {
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
?>
