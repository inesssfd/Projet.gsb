<?php
include_once '..\controleur\param_connexion.php';
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'supprimerAppartement' && isset($_GET['num_appt'])) {
        $num_appt = $_GET['num_appt'];
        // Appeler la fonction supprimerAppartement avec $num_appt
        Appartement::supprimerAppartement($num_appt);
    } elseif ($action == 'mettreAJourAppartement' && isset($_POST['num_appt'])) {
        $num_appt = $_POST['num_appt'];
        $champ = $_POST['champ'];  // Ajoutez la récupération du champ depuis le formulaire
        $nouvelleValeur = $_POST['nouvelleValeur'];
        
        // Appeler la fonction pour mettre à jour l'appartement
        Appartement::modifierAppartement($num_appt, $champ, $nouvelleValeur);
    }
    
}
class Appartement {
    private $num_appt;
    private $type_appt;
    private $prix_loc;
    private $prix_charge;
    private $rue;
    private $arrondisement;
    private $etage;
    private $ascenceur;
    private $preavis;
    private $date_libre;
    private $numero_prop;


    private $maConnexion;
    // Constructor
    public function __construct($num_appt,$type_appt, $prix_loc, $prix_charge, $rue, $arrondisement, $etage, $ascenceur, $preavis, $date_libre, $numero_prop) {
        $this->num_appt = $num_appt;
        $this->type_appt = $type_appt;
        $this->prix_loc = $prix_loc;
        $this->prix_charge = $prix_charge;
        $this->rue = $rue;
        $this->arrondisement = $arrondisement;
        $this->etage = $etage;
        $this->ascenceur = $ascenceur;
        $this->preavis = $preavis;
        $this->date_libre = $date_libre;
        $this->numero_prop = $numero_prop;

        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }

    // Getter and setter methods for each property
    public function getNumAppt() {
        return $this->num_appt;
    }
    public function getTypeAppt() {
        return $this->type_appt;
    }
    
    public function getPrixLoc() {
        return $this->prix_loc;
    }
    
    public function getPrixCharge() {
        return $this->prix_charge;
    }
    
    public function getRue() {
        return $this->rue;
    }
    
    public function getArrondisement() {
        return $this->arrondisement;
    }
    
    public function getEtage() {
        return $this->etage;
    }
    
    public function getAscenceur() {
        return $this->ascenceur;
    }
    
    
    public function getPreavis() {
        return $this->preavis;
    }
    
    public function getDateLibre() {
        return $this->date_libre;
    }
    
    public function getNumeroProp() {
        return $this->numero_prop;
    }

    public function setNumAppt($num_appt) {
        $this->num_appt = $num_appt;}

        public function ajouterAppartement()
        {
            // Requête SQL d'insertion
            $sql = "INSERT INTO appartement (type_appt, prix_loc, prix_charge, rue, arrondisement, etage, ascenceur, preavis, date_libre, numero_prop) 
                    VALUES (:type_appt, :prix_loc, :prix_charge, :rue, :arrondisement, :etage, :ascenseur, :preavis, :date_libre, :numero_prop)";
            
            try {
                $stmt = $this->maConnexion->prepare($sql);
                $stmt->bindParam(':type_appt', $this->type_appt);
                $stmt->bindParam(':prix_loc', $this->prix_loc);
                $stmt->bindParam(':prix_charge', $this->prix_charge);
                $stmt->bindParam(':rue', $this->rue);
                $stmt->bindParam(':arrondisement', $this->arrondisement);
                $stmt->bindParam(':etage', $this->etage);
                $stmt->bindParam(':ascenseur', $this->ascenseur);
                $stmt->bindParam(':preavis', $this->preavis);
                $stmt->bindParam(':date_libre', $this->date_libre);
                $stmt->bindParam(':numero_prop', $this->numero_prop);
            
                $stmt->execute();
            
                return true; // Succès de l'insertion
            } catch (PDOException $e) {
                // En cas d'erreur
                echo "Erreur d'insertion : " . $e->getMessage(); // Ajout de l'affichage de l'erreur spécifique
                return false;
            }
        }
        
    public static function getAllAppartementsByProprietaire($numero_prop) {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
    
        $sql = "SELECT * FROM appartement WHERE numero_prop = :numero_prop";
        $stmt = $maConnexion->prepare($sql);
        $stmt->bindParam(':numero_prop', $numero_prop, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAllAppartements() {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
    
        $sql = "SELECT * FROM appartement";
        $stmt = $maConnexion->query($sql);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFilteredAppartements($type_appt, $arrondisement, $prix_loc) {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
    
        // Utilisez des paramètres liés pour éviter les injections SQL
        $sql = "SELECT * FROM appartement WHERE 1";
    
        // Ajout des conditions en fonction des critères fournis
        if (!empty($type_appt)) {
            $sql .= " AND type_appt LIKE :type_appt";
            $typeParam = "%" . $type_appt . "%";
        }
    
        if (!empty($arrondisement)) {
            $sql .= " AND arrondisement LIKE :arrondisement";
            $arrondissementParam = "%" . $arrondisement . "%";
        }
    
        if (!empty($prix_loc)) {
            $sql .= " AND prix_loc <= :prix_loc";
        }
    
        $stmt = $maConnexion->prepare($sql);
    
        // Liaison des paramètres conditionnels
        if (isset($typeParam)) {
            $stmt->bindParam(':type_appt', $typeParam, PDO::PARAM_STR);
        }
    
        if (isset($arrondissementParam)) {
            $stmt->bindParam(':arrondisement', $arrondissementParam, PDO::PARAM_STR);
        }
    
        if (!empty($prix_loc)) {
            $stmt->bindParam(':prix_loc', $prix_loc, PDO::PARAM_INT);
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function supprimerAppartement($num_appt) {
        error_log("Fonction supprimerAppartement appelée pour num_appt=" . $num_appt);
        $connexionDB = new ConnexionDB();
        $pdo = $connexionDB->get_connexion();
        
        // Requête SQL DELETE avec le bon nom de table
        $sql = "DELETE FROM appartement WHERE num_appt = :num_appt";
        
        // Préparez et exécutez la requête
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':num_appt', $num_appt, PDO::PARAM_INT);
            $stmt->execute();
    
            // Renvoyer une réponse de succès au client
            echo "success";
            return true;
        } catch (PDOException $e) {
            // Renvoyer une réponse d'erreur au client
            echo "Erreur de suppression : " . $e->getMessage();
            return false;
        }
    }
    
    public static function modifierAppartement($num_appt, $nouveauType, $nouveauPrix, $nouvelleCharge, $nouvelleRue, $num_proprietaire_connecte) {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
    
        // Construction de la requête SQL
        $sql = "UPDATE appartement SET ";
        $updateFields = array();
    
        // Ajoutez les champs à mettre à jour seulement s'ils sont fournis avec des valeurs non nulles
        if ($nouveauType !== null) $updateFields[] = "type_appt = :nouveauType";
        if ($nouveauPrix !== null) $updateFields[] = "prix_loc = :nouveauPrix";
        if ($nouvelleCharge !== null) $updateFields[] = "prix_charge = :nouvelleCharge";
        if ($nouvelleRue !== null) $updateFields[] = "rue = :nouvelleRue";
    
        $sql .= implode(", ", $updateFields);
        $sql .= " WHERE num_appt = :num_appt";
    
        try {
            $stmt = $maConnexion->prepare($sql);
    
            // Ajoutez les liaisons de paramètres seulement pour les champs fournis avec des valeurs non nulles
            if ($nouveauType !== null) $stmt->bindParam(':nouveauType', $nouveauType);
            if ($nouveauPrix !== null) $stmt->bindParam(':nouveauPrix', $nouveauPrix);
            if ($nouvelleCharge !== null) $stmt->bindParam(':nouvelleCharge', $nouvelleCharge);
            if ($nouvelleRue !== null) $stmt->bindParam(':nouvelleRue', $nouvelleRue);
    
            // Ajoutez la liaison pour :num_appt
            $stmt->bindParam(':num_appt', $num_appt);
    
            $stmt->execute();
    
            // Modification réussie, renvoie une réponse JSON
            $response = array('status' => 'success');
            echo json_encode($response);
            return true; // Succès de la modification
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
            $response = array('status' => 'error', 'message' => 'Erreur de modification du propriétaire : ' . $e->getMessage());
            echo json_encode($response);
            return false; // En cas d'erreur
        }
    }
    
    public static function getAppartementsSansLocataire() {
        try {
            $connexionDB = new ConnexionDB();
            $maConnexion = $connexionDB->get_connexion();
            
            // Sélectionnez les appartements sans locataire
            $sql = "SELECT * FROM appartement WHERE num_appt NOT IN (SELECT num_appt FROM locataire)";
            $stmt = $maConnexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Créez des objets Appartement à partir des résultats
            $appartements = [];
            foreach ($result as $appartementData) {
                $appartement = new Appartement(
                    $appartementData['num_appt'],
                    $appartementData['type_appt'],
                    $appartementData['prix_loc'],
                    $appartementData['prix_charge'],
                    $appartementData['rue'],
                    $appartementData['arrondisement'],
                    $appartementData['etage'],
                    $appartementData['ascenceur'],
                    $appartementData['preavis'],
                    $appartementData['date_libre'],
                    $appartementData['numero_prop']
                );
                $appartements[] = $appartement;
            }
    
            return $appartements;
        } catch (PDOException $e) {
            // Gérez les exceptions ici (par exemple, en les enregistrant dans un fichier de journal)
            return false;
        }
    }
    
    }

?>
