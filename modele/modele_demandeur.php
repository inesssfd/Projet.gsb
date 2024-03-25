<?php
include_once '..\controleur\param_connexion.php';
class demandeurs {
    private $num_demandeur ;
	private $nom_demandeur ;
	private $prenom_demandeur;
	private $adresse_demandeur;
	private $cp_demandeur;
	private $tel_demandeur;
	private $login;
	private $motdepasse_demandeur;
    
    private $maConnexion;
	
    public function __construct($nom_demandeur='?', $prenom_demandeur='?', $adresse_demandeur='?', $cp_demandeur='?', $tel_demandeur='?', $login='?', $motdepasse_demandeur='?')
    {
        // Ne pas définir num_demandeur ici
        $this->nom_demandeur = $nom_demandeur;
        $this->prenom_demandeur = $prenom_demandeur;
        $this->adresse_demandeur = $adresse_demandeur;
        $this->cp_demandeur = $cp_demandeur;
        $this->tel_demandeur = $tel_demandeur;
        $this->login = $login;
        $this->motdepasse_demandeur = $motdepasse_demandeur;
    
        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }
    

    // Accesseurs


    public function getnum_demandeur() {
        return $this->num_demandeur;
    }
    public function getnom_demandeur() {
        return $this->nom_demandeur;
    }

    public function getprenom_demandeur() {
        return $this->prenom_demandeur;
    }
	
 public function getadresse_demandeur() {
        return $this->adresse_demandeur;
    }
	public function getcp_demandeur() {
        return $this->cp_demandeur;
    }

    public function getel_demandeur() {
        return $this->tel_demandeur;
    }
	public function getlogin() {
        return $this->login;
    }

    public function getmotdepasse_demandeur() {
        return $this->motdepasse_demandeur;
    }


    public function connexion($login, $motdepasse_demandeur) {
        try {
            $sql = "SELECT num_demandeur, motdepasse_demandeur FROM demandeurs WHERE login = :login";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && password_verify($motdepasse_demandeur, $result['motdepasse_demandeur'])) {
                return $result['num_demandeur']; // Retourne l'ID du demandeur
            } else {
                return false; // Échec de l'authentification
            }
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    }
public function inscription() {
    // Hash du mot de passe
    $hashedPassword = password_hash($this->motdepasse_demandeur, PASSWORD_DEFAULT);

    $sql = "INSERT INTO demandeurs (nom_demandeur, prenom_demandeur, adresse_demandeur, cp_demandeur, tel_demandeur, login, motdepasse_demandeur) 
            VALUES (:nom_demandeur, :prenom_demandeur, :adresse_demandeur, :cp_demandeur, :tel_demandeur, :login, :motdepasse_demandeur)";

    try {
        $stmt = $this->maConnexion->prepare($sql);
        $stmt->bindParam(':nom_demandeur', $this->nom_demandeur);
        $stmt->bindParam(':prenom_demandeur', $this->prenom_demandeur);
        $stmt->bindParam(':adresse_demandeur', $this->adresse_demandeur);
        $stmt->bindParam(':cp_demandeur', $this->cp_demandeur);
        $stmt->bindParam(':tel_demandeur', $this->tel_demandeur);
        $stmt->bindParam(':login', $this->login);
        $stmt->bindParam(':motdepasse_demandeur', $hashedPassword); // Utilisation du mot de passe haché
        $stmt->execute();

        // Set the num_demandeur property after successful insertion
        $this->num_demandeur = $this->maConnexion->lastInsertId();

        return true; // Succès de l'insertion
    } catch (PDOException $e) {
        return false; // En cas d'erreur
    }
}

public function supprimerDemandeur($num_demandeur) {
    try {
        $sql = "DELETE FROM demandeurs WHERE num_demandeur = :num_demandeur";
        $stmt = $this->maConnexion->prepare($sql);
        $stmt->bindParam(':num_demandeur', $num_demandeur);
        $stmt->execute();

        return true; // Succès de la suppression
    } catch (PDOException $e) {
        // Laissez l'appelant gérer l'erreur
        throw new Exception("Erreur de suppression du demandeur : " . $e->getMessage());
    }
}

    public function getDemandeurById($id) {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
        
        $sql = "SELECT * FROM demandeurs WHERE num_demandeur = :id";
        $stmt = $maConnexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function modifierDemandeur($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_demandeur_connecte) {
        error_log('La fonction modifierdemadneru est appelée.');
        $connexionDB = new ConnexionDB(); // Correction de la faute de frappe ici
        $maConnexion = $connexionDB->get_connexion();
        
    
        // Construction de la requête SQL
        $sql = "UPDATE demandeurs SET ";
        $updateFields = array();
    
        // Ajoutez les champs à mettre à jour seulement s'ils sont fournis avec des valeurs non nulles
        if ($nouveauNom !== null) $updateFields[] = "nom_demandeur = :nouveauNom";
        if ($nouveauPrenom !== null) $updateFields[] = "prenom_demandeur = :nouveauPrenom";
        if ($nouvelleAdresse !== null) $updateFields[] = "adresse_demandeur = :nouvelleAdresse";
        if ($nouveauCodePostal !== null) $updateFields[] = "cp_demandeur = :nouveauCodePostal";
        if ($nouveauTelephone !== null) $updateFields[] = "tel_demandeur = :nouveauTelephone";
    
        $sql .= implode(", ", $updateFields);
        $sql .= " WHERE num_demandeur = :num_demandeur_connecte";
    
        try {
            $stmt = $maConnexion->prepare($sql);
    
            // Ajoutez les liaisons de paramètres seulement pour les champs fournis avec des valeurs non nulles
            if ($nouveauNom !== null) $stmt->bindParam(':nouveauNom', $nouveauNom);
            if ($nouveauPrenom !== null) $stmt->bindParam(':nouveauPrenom', $nouveauPrenom);
            if ($nouvelleAdresse !== null) $stmt->bindParam(':nouvelleAdresse', $nouvelleAdresse);
            if ($nouveauCodePostal !== null) $stmt->bindParam(':nouveauCodePostal', $nouveauCodePostal);
            if ($nouveauTelephone !== null) $stmt->bindParam(':nouveauTelephone', $nouveauTelephone);
    
            // Ajoutez la liaison pour :
            $stmt->bindParam(':num_demandeur_connecte', $num_demandeur_connecte);
    
            $stmt->execute();
    
            error_log('Modification réussie du demandeur.');

            // Modification réussie, renvoie une réponse JSON
            $response = array('status' => 'success');
            echo json_encode($response);
            return true; // Succès de la modification
        } catch (PDOException $e) {
            // Affichez le message d'erreur spécifique
            error_log('Erreur de modification du demandeur : ' . $e->getMessage());
    
            // En cas d'erreur, renvoie une réponse JSON avec un message
            $response = array('status' => 'error', 'message' => 'Erreur de modification du demandeur : ' . $e->getMessage());
            echo json_encode($response);
            return false; // En cas d'erreur
        }
    }
    public function loginExiste($login) {
        $requete = "SELECT COUNT(*) AS count FROM demandeurs WHERE login = ?";
        $statement = $this->maConnexion->prepare($requete);
        $statement->execute([$login]);
        $resultat = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultat['count'] > 0;
    }
    
    
    
    public function getAllDemandeurs() {
        try {
            $connexionDB = new ConnexionDB();
            $maConnexion = $connexionDB->get_connexion();
            
            // Requête SQL pour récupérer tous les demandeurs
            $sql = "SELECT * FROM demandeurs";
            $stmt = $maConnexion->prepare($sql);
            $stmt->execute();
            $demandeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Retournez les demandeurs récupérés
            return $demandeurs;
        } catch (PDOException $e) {
            // Gérez les exceptions ici
            return false;
        }
    }
}    




