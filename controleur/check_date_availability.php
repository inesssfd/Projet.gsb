<?php
include_once '../modele/modele_visite.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numAppt = isset($_POST['num_appt']) ? intval($_POST['num_appt']) : 0;
    $dateVisite = isset($_POST['date_visite']) ? $_POST['date_visite'] : '';

    // Vérification de la disponibilité de la date
    $visite = new Visite('?'); // Remplacez '?' par l'ID de visite approprié
    $dateAvailable = $visite->isDateAvailable($numAppt, $dateVisite);

    // Réponse JSON
    echo json_encode(array("success" => $dateAvailable, "message" => $dateAvailable ? "Date disponible." : "Une visite avec la même date existe déjà."));
}
?>
