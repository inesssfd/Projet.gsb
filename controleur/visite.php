<?php
// Inclure le fichier contenant la classe Visite
require_once '../modele/modele_visite.php';

// Récupérer le numéro du demandeur à partir de la requête
$num_demandeur = $_GET['num_demandeur']; // Supposons que le numéro du demandeur soit passé dans l'URL

// Créer une instance de la classe Visite
$visite = new Visite();

// Appeler la fonction pour récupérer les visites du demandeur
$visites = $visite->getVisitesByDemandeur($num_demandeur);

?>
