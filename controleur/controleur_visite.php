<?php
// Vérifier si la session n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier contenant la définition de la classe Visite
include_once '..\modele\modele_visite.php';

// Traiter les données envoyées via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérifier si les données du formulaire sont présentes
        if (isset($_POST['num_demandeur'], $_POST['date_visite'], $_POST['num_appt'])) {
            // Récupérer les données du formulaire
            $num_demandeur = intval($_POST['num_demandeur']);
            $date_visite = $_POST['date_visite'];
            $num_appt = intval($_POST['num_appt']);

            // Appeler la méthode statique du modèle pour traiter la visite
            $message_traitement = Visite::traiterVisite($num_demandeur, $date_visite, $num_appt);
            
            // Afficher le message de retour
            echo $message_traitement;
        } else {
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
    }
}
// Traiter la modification de la date de visite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifyVisitDate') {
    // Vérifier si les données requises sont présentes
    if (isset($_POST['id_visite'], $_POST['nouvelle_date_visite'])) {
        // Récupérer les données de la requête
        $id_visite = intval($_POST['id_visite']);
        $nouvelle_date_visite = $_POST['nouvelle_date_visite'];

        // Créer une instance du modèle Visite
        $modeleVisite = new Visite();

        // Appeler la fonction pour modifier la date de visite
        $resultat = $modeleVisite->modifierDateVisite($id_visite, $nouvelle_date_visite);

        // Vérifier si la modification a réussi
        if ($resultat) {
            echo "Modification de la date de visite réussie.";
        } else {
            echo "Échec de la modification de la date de visite.";
        }
    } else {
        echo "Veuillez fournir l'identifiant de la visite et la nouvelle date de visite.";
    }
}


// Traiter l'action de suppression de visite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteVisit') {
echo"laaaa";
    if (isset($_POST['id_visite'])) {
        // Récupérer l'identifiant de la visite à supprimer
        $id_visite = intval($_POST['id_visite']);

        // Créer une instance du modèle Visite
        $modèleVisite = new Visite();

        // Appeler la fonction pour supprimer la visite
        $resultat = $modèleVisite->supprimerVisite($id_visite);

        // Envoyer une réponse au client
        echo $resultat ? 'Suppression réussie' : 'Échec de la suppression';
        exit(); // Terminer le script
    } else {
        echo "L'identifiant de la visite à supprimer est manquant.";
    }
}
$num_demandeur = $_GET['num_demandeur']; // Supposons que le numéro du demandeur soit passé dans l'URL

// Créer une instance de la classe Visite
$visite = new Visite();

// Appeler la fonction pour récupérer les visites du demandeur
$visites = $visite->getVisitesByDemandeur($num_demandeur);
?>
