<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../modele/modele_demande.php';
include_once '../modele/modele_proprietaire.php';
include_once '../modele/modele_app.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    // Vérifier si l'action est "supprimerProprietaireConnecte"
    if ($_POST['action'] === 'supprimerProprietaireConnecte') {
        // Vérifier si le numéro du propriétaire est défini dans la session
        if (isset($_SESSION['numero_prop'])) {
            $numero_prop = $_SESSION['numero_prop'];
            
            try {
                // Appeler la méthode pour supprimer le propriétaire
                $result = Proprietaire::supprimerProprietaire($numero_prop);
                // Afficher le résultat de l'opération
                echo $result ? "success" : "Erreur: Impossible de supprimer le propriétaire.";
            } catch (Exception $e) {
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            echo "Erreur: Numéro de propriétaire non spécifié dans la session.";
        }}}

// Vérifiez si le formulaire a été soumis et si l'action est "inscription"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'inscription') {
    // Créez une instance de la classe Proprietaire
    $proprietaire = new Proprietaire();
    
    // Récupérez les valeurs des champs du formulaire
    $nom_prop = $_POST['nom_prop'];
    $prenom_prop = $_POST['prenom_prop'];
    $adresse_prop = $_POST['adresse_prop'];
    $cp_prop = $_POST['cp_prop'];
    $tel_prop = $_POST['tel_prop'];
    $login_prop = $_POST['login_prop'];
    $motdepasse_pro = $_POST['motdepasse_pro'];
    
    // Définissez les valeurs des propriétés du propriétaire
    $proprietaire->setNomProp($nom_prop);
    $proprietaire->setPrenomProp($prenom_prop);
    $proprietaire->setAdresseProp($adresse_prop);
    $proprietaire->setCpProp($cp_prop);
    $proprietaire->setTelProp($tel_prop);
    $proprietaire->setLoginProp($login_prop);
    $proprietaire->setMotdepassePro($motdepasse_pro);
    
    // Appelez la méthode inscription
    $inscriptionResult = $proprietaire->inscription();
    
    // Vérifiez si l'inscription a réussi
    if ($inscriptionResult) {
        // Obtenez le numéro du propriétaire nouvellement inscrit
        $numero_prop = $proprietaire->getNumeroProp();
        
        // Démarrez la session pour le nouveau propriétaire
        demarrerSession($login_prop, $numero_prop);
        
        // Redirigez l'utilisateur vers la page d'accueil appropriée
        redirigerVersAccueilPro();
    } else {
        // En cas d'échec de l'inscription, redirigez avec les erreurs
        $proprietaire->redirigerAvecErreurs();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'connexion') {
        $login_prop = $_POST['login_prop'];
        $motdepasse_pro = $_POST['motdepasse_pro'];

        $proprietaire = new Proprietaire();
        $numero_prop = $proprietaire->connexion_prop($login_prop, $motdepasse_pro);

        if ($numero_prop) {
            // Les identifiants sont corrects, démarrer la session et rediriger
            $_SESSION['numero_prop'] = $numero_prop;
            demarrerSession($_POST['login_prop'], $numero_prop);
            redirigerVersAccueilPro();
        } else {
            // Identifiants incorrects, afficher un message d'erreur
            echo "Identifiants incorrects. Veuillez réessayer.";
            // Vous pouvez également rediriger vers une page de connexion avec un message d'erreur
            header("Location: ../vue/vue_connexion_proprietaire.php?erreur=identifiants_invalides");
            // exit();
        }
    }
}


function demarrerSession($login_prop, $numero_prop) {
    $_SESSION['login_prop'] = $login_prop;
    $_SESSION['numero_prop'] = $numero_prop;
    // Rediriger vers la page d'accueil du demandeur avec le numéro du demandeur dans l'URL
    header('Location: ../vue/v_acceuil_pro.php?login_prop=' . $login_prop);
    exit();
}


function redirigerVersAccueilPro() {
    header('Location: ../vue/v_acceuil_pro.php');
    exit();
}




$appartements = [];
$demandes_par_appartement = [];

// Vérification de la session et récupération des données des appartements et des demandes associées
if (isset($_SESSION['numero_prop'])) {
    $numero_prop = $_SESSION['numero_prop'];
    $appartements = Appartement::getAllAppartementsByProprietaire($numero_prop);

    // Tableau pour stocker les demandes associées à chaque appartement
    $demandes_par_appartement = [];

    foreach ($appartements as $appartement) {
        // Récupérer les demandes associées à cet appartement
        $demandes_par_appartement[$appartement['num_appt']] = Demande::getDemandesByAppartement($appartement['num_appt']);
    }
} else {
    header("Location: ../index.php");
    exit;
}

// Inclusion de la vue et envoi des données
include_once '../vue/v_acceuil_pro.php';
?>
