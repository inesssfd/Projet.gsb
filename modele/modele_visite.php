<?php
include_once '..\controleur\param_connexion.php';

class Visite {
    private $id_visite;
    private $num_demandeur;
    private $date_visite;
    private $num_appt;

    private $maConnexion;

    public function __construct($id_visite = '?', $num_demandeur = '?', $date_visite = '?', $num_appt = '?') {
        $this->id_visite = $id_visite;
        $this->num_demandeur = $num_demandeur;
        $this->date_visite = $date_visite;
        $this->num_appt = $num_appt;
    
        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }
    

    public function getNum_appt() {
        return $this->num_appt;
    }
    
    public function getDateVisite() {
        return $this->date_visite;
    }

 public function getVisitesByDemandeur($num_demandeur) {
        try {
            $sql = "SELECT * FROM visite WHERE num_demandeur = :num_demandeur";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':num_demandeur', $num_demandeur, PDO::PARAM_INT);
            $stmt->execute();

            // Récupérez toutes les visites associées au demandeur
            $visites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $visites;
        } catch (PDOException $e) {
            // Gérez les erreurs PDO si nécessaire
            echo "Erreur PDO : " . $e->getMessage();
            return false;
        }
    }

    public function visiter() {
        $sql = "INSERT INTO  visite (num_demandeur, date_visite, num_appt) 
        VALUES (:num_demandeur, :date_visite, :num_appt)";

try {
    $stmt = $this->maConnexion->prepare($sql);
    $stmt->bindParam(':num_demandeur', $this->num_demandeur, PDO::PARAM_INT);
    $stmt->bindParam(':date_visite', $this->date_visite);
    $stmt->bindParam(':num_appt', $this->num_appt);
    $stmt->execute();
    return true; // Succès de l'insertion
} catch (PDOException $e) {
    echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
    return false;
}

    }

    public function verifierNumApptExiste($num_appt) {
        try {
            // Exécutez une requête pour vérifier si le num_appt existe
            $requete = $this->maConnexion->prepare("SELECT COUNT(*) FROM appartement WHERE num_appt = :num_appt");
            $requete->bindParam(':num_appt', $num_appt, PDO::PARAM_INT);
            $requete->execute();
    
            // Récupérez le résultat de la requête
            $resultat = $requete->fetchColumn();
    
            // Fermez la requête
            $requete->closeCursor();
    
            // Retournez le résultat de la vérification
            return $resultat > 0;
        } catch (PDOException $e) {
            // Gérez les erreurs PDO si nécessaire
            echo "Erreur PDO : " . $e->getMessage();
            return false;
        }
    }

    public function modifierDateVisite($id_visite, $nouvelle_date_visite) {
        try {
            $sql = "UPDATE visite SET date_visite = :nouvelle_date_visite WHERE id_visite = :id_visite";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':nouvelle_date_visite', $nouvelle_date_visite);
            $stmt->bindParam(':id_visite', $id_visite, PDO::PARAM_INT);
            $stmt->execute();
    
            return true; // Succès de la modification
        } catch (PDOException $e) {
            echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
            return false;
        }
    }
    
public function supprimerVisite($id_visite) {
    try {
        $sql = "DELETE FROM visite WHERE id_visite = :id_visite";
        $stmt = $this->maConnexion->prepare($sql);
        $stmt->bindParam(':id_visite', $id_visite, PDO::PARAM_INT);
        $stmt->execute();

        return true; // Succès de la suppression
    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
        return false;
    }
}
}



