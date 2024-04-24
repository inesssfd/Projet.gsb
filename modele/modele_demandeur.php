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
    public function setnom_demandeur($nom_demandeur) {
        $this->nom_demandeur = $nom_demandeur;
    }
    public function setprenom_demandeur($prenom_demandeur) {
        $this->prenom_demandeur = $prenom_demandeur;
    }
    
    public function setadresse_demandeur($adresse_demandeur) {
        $this->adresse_demandeur = $adresse_demandeur;
    }
    
    public function setcp_demandeur($cp_demandeur) {
        $this->cp_demandeur = $cp_demandeur;
    }
    
    public function settel_demandeur($tel_demandeur) {
        $this->tel_demandeur = $tel_demandeur;
    }
    
    public function setlogin($login) {
        $this->login = $login;
    }
    
    public function setmotdepasse_demandeur($motdepasse_demandeur) {
        $this->motdepasse_demandeur = $motdepasse_demandeur;
    }
    public function getLastInsertId() {
        return $this->maConnexion->lastInsertId();
    }

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
    public function champsNomPrenomValides() {
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $this->nom_demandeur) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $this->prenom_demandeur);
    }

    public function champsCpTelValides() {
        return preg_match("/^\d+$/", $this->cp_demandeur) && preg_match("/^\d+$/", $this->tel_demandeur);
    }
    public function champsVides() {
        return empty($this->nom_demandeur) || empty($this->prenom_demandeur) || empty($this->adresse_demandeur) || empty($this->cp_demandeur) || empty($this->tel_demandeur) || empty($this->login) || empty($this->motdepasse_demandeur);
    }
        public function inscription() {
            $this->errors = []; 
        
            // Vérifier si tous les champs sont vides
            if ($this->champsVides()) {
                $this->errors[] = "Tous les champs doivent être remplis.";
            }
            
            // Vérifier si les champs nom et prénom sont valides
            if (!$this->champsNomPrenomValides()) {
                $this->errors[] = "Les champs nom et prénom ne doivent contenir que des lettres et des espaces.";
            }
        
            // Vérifier si les champs code postal et téléphone sont valides
            if (!$this->champsCpTelValides()) {
                $this->errors[] = "Les champs code postal et téléphone doivent contenir uniquement des chiffres.";
            }
        
            // Si des erreurs sont présentes, retourner false
            if (!empty($this->errors)) {
                return false;
            }
        
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
        
                // Récupérer l'ID de la dernière insertion
                $this->num_demandeur = $this->maConnexion->lastInsertId();
        
                return true; // Succès de l'insertion
            } catch (PDOException $e) {
                return false; // En cas d'erreur
            }
        }
         public function redirigerAvecErreurs($errors) {
            // Construire la chaîne de requête avec les erreurs
            $errorString = implode("&", array_map(function($error) {
                return "error[]=" . urlencode($error);
            }, $errors));
        
            // Utiliser la chaîne de requête avec les erreurs dans la redirection
            header("Location: ../vue/vue_inscription_demandeur.php?" . $errorString);
            exit();
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
        echo "Requête SQL : "  . "<br>";
        echo "Requête SQL : sdqdqs"  . "<br>";

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




