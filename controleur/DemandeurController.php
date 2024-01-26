<?php
// DemandeurController.php

include_once '../modele/modele_app.php';

class DemandeurController {
    public static function rechercherAppartements() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Récupérer les paramètres de recherche
        $type_appt = isset($_GET['type_appt']) ? $_GET['type_appt'] : '';
        $arrondisement = isset($_GET['arrondisement']) ? $_GET['arrondisement'] : '';
        $prix_loc = isset($_GET['prix_loc']) ? $_GET['prix_loc'] : PHP_INT_MAX;

        // Filtrer les appartements en fonction des critères de recherche
        return Appartement::getFilteredAppartements($type_appt, $arrondisement, $prix_loc);
    }
}
?>
