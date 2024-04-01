<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../modele/modele_app.php';

$confirmation = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire d'ajout, de modification ou de suppression est soumis
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'ajouterAppartement') {
            ajouterAppartement();
        } elseif ($_POST['action'] === 'modifierAppartement') {
            modifierAppartement();
        } elseif ($_POST['action'] === 'supprimerAppartement') {
            $this->supprimerAppartement(); // Correction ici
        }
    }
}



function getAppartementsSansLocataireEtDateLibrePasse() {
    try {
        // Appeler la méthode statique de la classe Appartement pour récupérer les appartements sans locataire
        return Appartement::getAppartementsSansLocataireEtDateLibrePasse();
    } catch (PDOException $e) {
        // Gérer les exceptions PDO ici (par exemple, en les enregistrant dans un fichier journal)
        return false;
    }
}


function ajouterAppartement() {
    // Validation du prix_loc pour s'assurer qu'il ne contient que des chiffres
    if (!champ_prix()) {
        $GLOBALS['errors'][] = "Les champs prix et ascenceur ne doivent contenir que des chiffres.";
        redirigerAvecErreurs();
        return;
    }
    
    $num_appt = $_POST['num_appt'];
    $type_appt = $_POST['type_appt'];
    $prix_loc = $_POST['prix_loc'];
    $prix_charge = $_POST['prix_charge'];
    $rue = $_POST['rue'];
    $arrondisement = $_POST['arrondisement'];
    $etage = $_POST['etage'];
    $ascenceur = $_POST['ascenceur'];
    $preavis = $_POST['preavis'];
    $date_libre = $_POST['date_libre'];
    $numero_prop = $_POST['numero_prop'];

    $appartement = new Appartement($num_appt, $type_appt, $prix_loc, $prix_charge, $rue, $arrondisement, $etage, $ascenceur, $preavis, $date_libre, $numero_prop);

    try {
        if ($appartement->ajouterAppartement()) {
            // Redirection avec un message de succès
            header('Location: ../vue/v_acceuil_pro.php?success=1');
            exit();
        } else {
            // En cas d'échec, stocker le message d'erreur dans la variable de session
            $_SESSION['confirmation'] = "Erreur lors de l'ajout de l'appartement vous avez deja trop d'appartement";
            $GLOBALS['confirmation'] = $_SESSION['confirmation'];
        }
    } catch (PDOException $e) {
        // En cas d'erreur PDO, affichez le message d'erreur spécifique
        $_SESSION['confirmation'] = "Erreur lors de l'ajout de l'appartement : " . $e->getMessage();
        $GLOBALS['confirmation'] = $_SESSION['confirmation'];
    }
}

function champ_prix() {
    return preg_match("/^\d+$/", $_POST['prix_loc']) && preg_match("/^\d+$/", $_POST['prix_charge'])&& preg_match("/^\d+$/", $_POST['etage']);
}


function modifierAppartement() {
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
        $GLOBALS['confirmation'] = "L'appartement a été modifié avec succès.";
    } else {
        // Erreur lors de la modification
        $GLOBALS['confirmation'] = "Erreur lors de la modification de l'appartement.";
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
