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
    public function updateDateVisite($id_visite, $nouvelle_date) {
        try {
            $sql = "UPDATE visite SET date_visite = :nouvelle_date WHERE id_visite = :id_visite";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':id_visite', $id_visite, PDO::PARAM_INT);
            $stmt->bindParam(':nouvelle_date', $nouvelle_date);
            $stmt->execute();

            return true; // Succès de la mise à jour
        } catch (PDOException $e) {
            echo "Erreur PDO lors de la préparation ou de l'exécution de la requête : " . $e->getMessage();
            return false;
        }
    }
}

// Reste du code inchangé...

// Nouvelle fonction pour gérer la mise à jour de la date
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'updateDate') {
        $id_visite = $_POST['id_visite'];
        $nouvelle_date = $_POST['nouvelle_date'];

        // Créez une instance de la classe Visite
        $visite = new Visite();
        
        // Appelez la fonction pour mettre à jour la date
        $resultat = $visite->updateDateVisite($id_visite, $nouvelle_date);

        // Envoyez une réponse au client
        echo $resultat ? 'Mise à jour réussie' : 'Échec de la mise à jour';
        exit(); // Assurez-vous de terminer le script ici
    }
}



