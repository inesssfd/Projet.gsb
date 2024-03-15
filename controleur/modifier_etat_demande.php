<?php
// Vérifiez d'abord si la requête est une requête POST valide
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les données requises sont présentes
    if (isset($_POST["id_demande"]) && isset($_POST["nouvel_etat"])) {
        // Récupérez les données de la requête
        $idDemande = $_POST["id_demande"];
        $nouvelEtat = ($_POST["nouvel_etat"] == 'Acceptée') ? 'Acceptée' : 'Refusée';



        // Affichage de la valeur pour le débogage
        echo "ID de la demande : " . $idDemande . "<br>";
echo "Nouvel état de la demande : " . $nouvelEtat . "<br>";


        // Validation des données
        if (!is_numeric($idDemande)) {
            // Gérer l'erreur si l'ID de la demande n'est pas valide
            echo "L'ID de la demande n'est pas valide.";
            exit; // Arrête l'exécution du script
        }
        echo "Validation des données terminée. <br>";

        // Inclure votre classe Demande
        include_once '..\controleur\param_connexion.php';
        include_once '..\modele\modele_demande.php';

        // Créer une instance de la classe Demande
        $demande = new Demande();

echo "Avant la mise à jour de l'état de la demande : <br>";
echo "ID de la demande : " . $idDemande . "<br>";
echo "Nouvel état de la demande : " . $nouvelEtat . "<br>";
echo "ID de la demande à mettre à jour : " . $idDemande . "<br>";
$resultat = $demande->updateetat_demande($nouvelEtat, $idDemande);




        // Vérifier si la mise à jour a réussi
        if ($resultat) {
            // Envoyez une réponse JSON pour indiquer le succès de la mise à jour
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit; // Arrêtez l'exécution du script
        } else {
            // Si la mise à jour a échoué, renvoyez une réponse d'erreur
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour de l\'état de la demande']);
            exit; // Arrêtez l'exécution du script
        }
    } else {
        // Si les données requises ne sont pas présentes, renvoyez une réponse d'erreur
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Données requises manquantes']); // Réponse indiquant une erreur
        exit; // Arrêtez l'exécution du script
    }
} else {
    // Si la méthode de requête est incorrecte, renvoyez une réponse d'erreur
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Requête invalide']); // Réponse indiquant une erreur
    exit; // Arrêtez l'exécution du script
}
?>
