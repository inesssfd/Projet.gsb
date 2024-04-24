<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../modele/modele_app.php';

$confirmation = '';
$errors = [];

$type_appt = isset($_GET['type_appt']) ? $_GET['type_appt'] : null;
$arrondisement = isset($_GET['arrondisement']) ? $_GET['arrondisement'] : null;
$prix_max = isset($_GET['prix']) ? $_GET['prix'] : null;
$appartements = Appartement::getAppartementsSansLocataireEtDateLibrePasse();

if ($appartements !== false && count($appartements) > 0) {
} else {
    // Aucun appartement trouvé ou erreur lors de la récupération
    echo "Aucun appartement disponible pour le moment.";
}
// Vérification si les données POST sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'ajouterAppartement') {
        $appartement = new Appartement();
        $appartement->setTypeAppt($_POST['type_appt']);
        $appartement->setPrixLoc($_POST['prix_loc']);
        $appartement->setPrixCharge($_POST['prix_charge']);
        $appartement->setRue($_POST['rue']);
        $appartement->setArrondisement($_POST['arrondisement']);
        $appartement->setEtage($_POST['etage']);
        $appartement->setAscenceur(isset($_POST['ascenseur']) ? $_POST['ascenseur'] : 0);
        $appartement->setPreavis($_POST['preavis']);
        $appartement->setDateLibre($_POST['date_libre']);
        $appartement->setNumeroProp($_POST['numero_prop']);


    // Appel de la méthode ajouterAppartement de l'objet $appartement
    if ($appartement->ajouterAppartement()) {
        // Redirection vers une page de succès
        header("Location: ../vue/v_acceuil_pro.php");
        exit();
    } else {
        $_SESSION['confirmation'] = "Erreur lors de l'ajout de l'appartement : Impossible d'ajouter un nouvel appartement. Limite atteinte pour ce propriétaire.";
        header('Location: ../vue/ajouter_logement.php'); // Redirection vers la page d'ajout d'appartement
        exit();
    }
} elseif ($_POST['action'] === 'modifierAppartement') {
    // Récupération des données du formulaire
    $num_appt = $_POST['num_appt'];
    $num_prop = isset($_POST['num_proprietaire_connecte']) ? $_POST['num_proprietaire_connecte'] : null;
    // Appel de la fonction pour modifier l'appartement
    $modification_reussie = modifierAppartement($num_appt, $num_prop);

    // Vérification de la réussite de la modification
    if ($modification_reussie) {
        echo json_encode(array('status' => 'success', 'message' => 'Modification réussie.'));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Échec de la modification.'));
        exit;
    }
} else {
    // Si l'action est inconnue
    echo json_encode(array('status' => 'error', 'message' => 'Action inconnue.'));
    exit;
}}

function modifierAppartement($num_appt, $num_prop) {
    // Vérifier si toutes les données nécessaires sont présentes
    if (isset($_POST['nouveauType'], $_POST['nouveauPrix'], $_POST['nouvelleCharge'], $_POST['nouvelleRue'])) {
        // Récupérer les nouvelles valeurs des champs éditables
        $nouveauType = $_POST['nouveauType'];
        $nouveauPrix = $_POST['nouveauPrix'];
        $nouvelleCharge = $_POST['nouvelleCharge'];
        $nouvelleRue = $_POST['nouvelleRue'];

        // Appeler la fonction pour modifier l'appartement
        $modification_reussie = Appartement::modifierAppartement($num_appt, $nouveauType, $nouveauPrix, $nouvelleCharge, $nouvelleRue, $num_prop);

        return $modification_reussie;
    } else {
        return false;
    }
}


function redirigerAvecErreurs() {
    $errorString = implode("&", array_map(function($error) {
        return "error[]=" . urlencode($error);
    }, $GLOBALS['errors']));

    header("Location: ../vue/ajouter_logement.php?" . $errorString);
    exit();
}


echo $confirmation;
?>
