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
    public static function traiterVisite($num_demandeur, $date_visite, $num_appt) {
        try {
            // Vérifier si la date de visite est antérieure à la date actuelle
            $date_actuelle = date('Y-m-d'); // Obtenez la date actuelle au format 'AAAA-MM-JJ'
    
            if ($date_visite < $date_actuelle) {
                return "La date de visite ne peut pas être antérieure à la date actuelle.";
            }
    
            // Créer une instance de la classe Visite
            $visite = new Visite(null, $num_demandeur, $date_visite, $num_appt);
    
            // La date de visite est valide, procédez au traitement
            if ($visite->visiter()) {
                header('Location: ../vue/v_acceuil_demandeur.php');
            } else {
                return "Erreur lors de l'enregistrement de la visite prévue.";
            }
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            return "Erreur PHP : " . $e->getMessage();
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
}}


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
            // Préparer la requête SQL
            $sql = "DELETE FROM visite WHERE id_visite = :id_visite";
            $stmt = $this->maConnexion->prepare($sql);
            
            // Binder les valeurs
            $stmt->bindParam(':id_visite', $id_visite, PDO::PARAM_INT);
            
            // Exécuter la requête
            $stmt->execute();
    
            // Vérifier si la suppression a réussi
            if ($stmt->rowCount() > 0) {
                return true; // Suppression réussie
            } else {
                return false; // Aucune ligne n'a été supprimée, probablement parce que l'ID de visite n'existe pas
            }
        } catch (PDOException $e) {
            echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
            return false; // Erreur lors de la suppression
        }
    }
    
    public function getAllVisite() {
        try {
            $connexionDB = new ConnexionDB();
            $maConnexion = $connexionDB->get_connexion();
            
            // Requête SQL pour récupérer tous les propriétaires
            $sql = "SELECT * FROM visite";
            $stmt = $maConnexion->prepare($sql);
            $stmt->execute();
            $visite = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Retournez les propriétaires récupérés
            return $visite;
        } catch (PDOException $e) {
            // Gérez les exceptions ici
            return false;
        }
    }
}

