<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '..\modele\modele_proprietaire.php';

// Vérifiez si 'numero_prop' est défini dans $_SESSION
// Assurez-vous d'avoir le numéro du propriétaire
if (isset($_SESSION['numero_prop'])) {
    $numero_prop = $_SESSION['numero_prop'];

    // Créez une instance de la classe proprietaire
    $proprietaire = new proprietaire();

    // Obtenez le loyer total pour le propriétaire
    $loyerTotal = $proprietaire->getLoyerTotalParProprietaire($numero_prop);

    // Maintenant vous pouvez utiliser $loyerTotal comme nécessaire
} else {
    // Gérez le cas où 'numero_prop' n'est pas défini dans la session
    echo "Le paramètre 'numero_prop' n'est pas défini dans la session.";
}

?>
