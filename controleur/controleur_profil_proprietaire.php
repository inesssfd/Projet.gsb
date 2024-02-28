<?php
session_start();
include_once '../modele/modele_proprietaire.php';

class ProprietaireController {
    private $proprietaire;

    public function __construct() {
        $this->proprietaire = new Proprietaire();
    }

    public function getDetailsProprietaire() {
        if (isset($_SESSION['numero_prop'])) {
            $numero_prop = $_SESSION['numero_prop'];
            return $this->proprietaire->getDetailsProprietaireById($numero_prop);
        }
        return [];
    }

    public function supprimerProprietaireConnecte() {
        if (isset($_SESSION['numero_prop'])) {
            $numero_prop = $_SESSION['numero_prop'];
            $success = $this->proprietaire->supprimerProprietaire($numero_prop);
            if ($success) {
                session_destroy();
                return true;
            }
        }
        return false;
    }
}

$controller = new ProprietaireController();

if (isset($_POST['action']) && $_POST['action'] === 'supprimerProprietaireConnecte') {
    $success = $controller->supprimerProprietaireConnecte();
    if ($success) {
        echo 'success';
        exit;
    } else {
        echo 'error';
        exit;
    }
}

$details_proprietaire = $controller->getDetailsProprietaire();
?>
