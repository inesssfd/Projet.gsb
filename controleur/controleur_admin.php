<?php
include_once '../modele/modele_demandeur.php'; // Inclure le modèle demandeur
include_once '../modele/modele_proprietaire.php';
include_once '../modele/modele_loc.php';
include_once '../modele/modele_app.php';
include_once '../modele/modele_visite.php';
// Méthode pour afficher les données dans la vue admin
function afficherVueAdmin() {
    $modeleDemandeur = new demandeurs();
    $modeleProprietaire = new proprietaire();
    $modeleLocataire = new Locataire();
    $modeleAppartement = new Appartement();
    $modeleVisite = new Visite();
    
    $chiffreAffairesTotal = $modeleProprietaire->getChiffreAffairesTotal();
    $demandeurs = $modeleDemandeur->getAllDemandeurs(); 
    $proprietaires = $modeleProprietaire->getAllProprietaire();
    $locataire = $modeleLocataire->getAllLocataire();
    $appartementData = $modeleAppartement->getAllAppartement();
    $visite = $modeleVisite->getAllVisite();
    
    // Construct Appartement objects with data
    $appartements = [];
    foreach ($appartementData as $appartementInfo) {
        $appartement = new Appartement(
            $appartementInfo['num_appt'],
            $appartementInfo['type_appt'],
            $appartementInfo['prix_loc'],
            $appartementInfo['prix_charge'],
            $appartementInfo['rue'],
            $appartementInfo['arrondisement'],
            $appartementInfo['etage'],
            $appartementInfo['ascenceur'],
            $appartementInfo['preavis'],
            $appartementInfo['date_libre'],
            $appartementInfo['numero_prop']
        );
        $appartements[] = $appartement;
    }
    
    // Retourner les données des demandeurs, propriétaires, locataires, appartements et chiffre d'affaires total
    return array('demandeurs' => $demandeurs, 'proprietaires' => $proprietaires, 'locataire' => $locataire, 'appartement' => $appartements, 'visite' => $visite, 'chiffreAffairesTotal' => $chiffreAffairesTotal);
}

// Méthode pour supprimer un demandeur
 function supprimerDemandeur($num_demandeur) {
    // Instancier le modèle Demandeur
    $demandeurModel = new demandeurs();

    try {
        // Appeler la méthode de suppression du demandeur
        $result = $demandeurModel->supprimerDemandeur($num_demandeur);

        if ($result) {
            // Rediriger vers la page d'administration avec un message de succès
            header("Location: ../vue/administrateur.php?success=deleted");
            exit;
        } else {
            // Rediriger vers la page d'administration avec un message d'erreur
            header("Location:../vue/administrateur.php?error=delete_failed");
            exit;
        }
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la suppression du demandeur : " . $e->getMessage();
    }
}

 function supprimerProprietaireAdmin($numero_prop) {
    // Instancier le modèle Proprietaire
    $modeleProprietaire = new proprietaire();

    try {
        // Appeler la méthode de suppression du propriétaire
        $result = $modeleProprietaire->supprimerProprietaire($numero_prop);

        if ($result) {
            // Rediriger vers la page d'administration avec un message de succès
            header("Location: ../vue/administrateur.php?success=deleted");
            exit;
        } else {
            // Rediriger vers la page d'administration avec un message d'erreur
            header("Location:../vue/administrateur.php?error=delete_failed");
            exit;
        }
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la suppression du propriétaire : " . $e->getMessage();
    }
}

 function supprimerAppartementAdmin($num_appt) {
    // Instancier le modèle Appartement
    $modeleAppartement = new Appartement();

    try {
        // Appeler la méthode de suppression de l'appartement
        $result = $modeleAppartement->supprimerAppartement($num_appt);

        if ($result) {
            // Rediriger vers la page d'administration avec un message de succès
            header("Location: ../vue/administrateur.php?success=deleted");
            exit;
        } else {
            // Rediriger vers la page d'administration avec un message d'erreur
            header("Location:../vue/administrateur.php?error=delete_failed");
            exit;
        }
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la suppression de l'appartement : " . $e->getMessage();
    }
}

 function supprimerVisiteAdmin($id_visite) {
    // Instancier le modèle Visite
    $modeleVisite = new Visite();

    try {
        // Appeler la méthode de suppression de visite
        $result = $modeleVisite->supprimerVisite($id_visite);

        if ($result) {
            // Rediriger vers la page d'administration avec un message de succès
            header("Location: ../vue/administrateur.php?success=deleted");
            exit;
        } else {
            // Rediriger vers la page d'administration avec un message d'erreur
            header("Location:../vue/administrateur.php?error=delete_failed");
            exit;
        }
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la suppression de la visite : " . $e->getMessage();
    }
}

 function supprimerLocataire($num_loc) {
    // Instancier le modèle Locataire
    $modeleLocataire = new Locataire();

    try {
        // Appeler la méthode de suppression du locataire
        $result = $modeleLocataire->supprimerLocataire($num_loc);

        if ($result) {
            // Rediriger vers la page d'administration avec un message de succès
            header("Location: ../vue/administrateur.php?success=deleted");
            exit;
        } else {
            // Rediriger vers la page d'administration avec un message d'erreur
            header("Location: ../vue/administrateur.php?error=delete_failed");
            exit;
        }
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la suppression du locataire : " . $e->getMessage();
    }
}
function modifier_locataire($num_loc, $nouvellesDonnees) {
    // Instancier le modèle Locataire
    $modeleLocataire = new Locataire();
    var_dump($num_loc);
    var_dump($nouvellesDonnees);
    try {
        // Décoder les données JSON en un tableau associatif
        $nouvellesDonnees = json_decode($nouvellesDonnees, true);

        // Appeler la méthode de modification du locataire
        $result = $modeleLocataire->modifierLocataireAdmin($num_loc, $nouvellesDonnees);

        // Reste du code ...
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la modification du locataire : " . $e->getMessage();
    }
}
function modifier_proprietaire($numero_prop, $nouvellesDonnees) {
    // Instancier le modèle Locataire
    $modeleProprietaire = new Locataire();
    var_dump($numero_prop);
    var_dump($nouvellesDonnees);
    try {
        // Décoder les données JSON en un tableau associatif
        $nouvellesDonnees = json_decode($nouvellesDonnees, true);

        // Appeler la méthode de modification du locataire
        $result = $modeleProprietaire->modifierProprietaireAdmin($numero_prop, $nouvellesDonnees);

        // Reste du code ...
    } catch (Exception $e) {
        // Gérer l'exception, éventuellement en affichant un message d'erreur à l'utilisateur
        echo "Erreur lors de la modification du locataire : " . $e->getMessage();
    }
}

if (isset($_GET['action'])) {
    // Vérifier quelle action doit être effectuée
    if ($_GET['action'] === 'supprimer_demandeur') {
        // Vérifier si le numéro du demandeur est fourni dans l'URL
        if (isset($_GET['num_demandeur']) && !empty($_GET['num_demandeur'])) {
            // Récupérer le numéro du demandeur depuis l'URL
            $num_demandeur = $_GET['num_demandeur'];
            supprimerDemandeur($num_demandeur);
        }
    } elseif ($_GET['action'] === 'supprimer_proprietaire') {
        echo "Bloc 'supprimer_proprietaire' exécuté avec succès.";
        // Vérifier si le numéro du propriétaire est fourni dans l'URL
        if (isset($_GET['num_proprietaire']) && !empty($_GET['num_proprietaire'])) {
            // Récupérer le numéro du propriétaire depuis l'URL
            $num_proprietaire = $_GET['num_proprietaire'];
            
            // Appeler la méthode pour supprimer le propriétaire avec le numéro spécifié
            supprimerProprietaireAdmin($num_proprietaire);
        }
    } elseif ($_GET['action'] === 'supprimer_appartement') {
        // Vérifier si le numéro de l'appartement est fourni dans l'URL
        if (isset($_GET['num_appt']) && !empty($_GET['num_appt'])) {
            // Récupérer le numéro de l'appartement depuis l'URL
            $num_appt = $_GET['num_appt'];
            
            // Appeler la méthode pour supprimer l'appartement avec le numéro spécifié
            supprimerAppartementAdmin($num_appt);
        }
    }
        elseif ($_GET['action'] === 'supprimer_visite') {
            // Vérifier si l'ID de la visite est fourni dans l'URL
            if (isset($_GET['id_visite']) && !empty($_GET['id_visite'])) {
                // Récupérer l'ID de la visite depuis l'URL
                $id_visite = $_GET['id_visite'];
                
                // Appeler la méthode pour supprimer la visite avec l'ID spécifié
                supprimerVisiteAdmin($id_visite);
            }
        } elseif ($_GET['action'] === 'modifier_locataire') {
            // Afficher les données reçues
            var_dump($_POST['num_loc']);
            var_dump($_POST['nouvellesDonnees']);
            
            // Vérifier si le numéro du locataire et les nouvelles données sont fournis dans la requête POST
            if (isset($_POST['num_loc']) && isset($_POST['nouvellesDonnees'])) {
                // Récupérer le numéro du locataire et les nouvelles données depuis la requête POST
                $num_loc = $_POST['num_loc'];
                $nouvellesDonnees = $_POST['nouvellesDonnees'];
                
                // Appeler la méthode pour modifier le locataire avec les nouvelles données
                modifier_locataire($num_loc, $nouvellesDonnees);
            }
        }
        elseif ($_GET['action'] === 'modifier_proprietaire') {
            // Afficher les données reçues
            var_dump($_POST['numero_prop']);
            var_dump($_POST['nouvellesDonnees']);
            
            // Vérifier si le numéro du locataire et les nouvelles données sont fournis dans la requête POST
            if (isset($_POST['numero_prop']) && isset($_POST['nouvellesDonnees'])) {
                // Récupérer le numéro du locataire et les nouvelles données depuis la requête POST
                $num_loc = $_POST['numero_prop'];
                $nouvellesDonnees = $_POST['nouvellesDonnees'];
                
                // Appeler la méthode pour modifier le locataire avec les nouvelles données
                modifier_proprietaire($numero_prop, $nouvellesDonnees);
            }
        }
    }
?>