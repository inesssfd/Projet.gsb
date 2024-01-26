<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();
// Rediriger vers la page d'accueil ou l'index
header('Location:../index.php'); // Utilisez /index.php si votre index est à la racine du site
 // Utilisez /index.php si votre index est à la racine du site
exit();
