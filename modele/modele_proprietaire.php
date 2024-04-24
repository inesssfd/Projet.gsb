<?php
include_once '..\controleur\param_connexion.php';

class proprietaire {
    private $numero_prop;
    private $nom_prop;
    private $prenom_prop;
    private $adresse_prop;
    private $cp_prop;
    private $tel_prop;
    private $login_prop;
    private $motdepasse_pro;

    private $maConnexion;

    public function __construct($nom_prop = '?', $prenom_prop = '?', $adresse_prop = '?', $cp_prop = '?', $tel_prop = '?', $login_prop = '?', $motdepasse_pro = '?') {
        $this->nom_prop = $nom_prop;
        $this->prenom_prop = $prenom_prop;
        $this->adresse_prop = $adresse_prop;
        $this->cp_prop = $cp_prop;
        $this->tel_prop = $tel_prop;
        $this->login_prop = $login_prop;
        $this->motdepasse_pro = $motdepasse_pro;
    
        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    
        // Ajoutez cette ligne pour initialiser $this->numero_prop
        $this->numero_prop = null; // Vous pouvez définir la valeur par défaut que vous préférez
    }
    public function setNomProp($nom_prop) {
        $this->nom_prop = $nom_prop;
    }
    public function setPrenomProp($prenom_prop) {
        $this->prenom_prop = $prenom_prop;
    }
    public function setAdresseProp($adresse_prop) {
        $this->adresse_prop = $adresse_prop;
    }
    public function setCpProp($cp_prop) {
        $this->cp_prop = $cp_prop;
    }
    public function setTelProp($tel_prop) {
        $this->tel_prop = $tel_prop;
    }
    public function setLoginProp($login_prop) {
        $this->login_prop = $login_prop;
    }
    public function setMotdepassePro($motdepasse_pro) {
        $this->motdepasse_pro = $motdepasse_pro;
    }
    public function getLoginProp() {
        return $this->login_prop;
    }

    public function getNumeroProp() {
        return $this->numero_prop;
    }
    public function getnom_prop() {
        return $this->nom_prop;
    }
  public  function champsVides() {
    error_log("Méthode champsVides appelée.");
        return empty($_POST['nom_prop']) || empty($_POST['prenom_prop']) || empty($_POST['adresse_prop']) || empty($_POST['cp_prop']) || empty($_POST['tel_prop']) || empty($_POST['login_prop']) || empty($_POST['motdepasse_pro']);
    }
    
    public function champsNomPrenomValides() {
        error_log("Méthode champsVides appelée.");
        return preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['nom_prop']) && preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $_POST['prenom_prop']);
    }
    
    public function champsCpTelValides() {
        error_log("Méthode champsVides appelée.");
        return preg_match("/^\d+$/", $_POST['cp_prop']) && preg_match("/^\d+$/", $_POST['tel_prop']);
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
    
        // Vérifier si le login existe déjà
        if ($this->loginExiste($_POST['login_prop'])) {
            $this->errors[] = "Ce login est déjà utilisé. Veuillez en choisir un autre.";
        }
    
        // Si des erreurs sont présentes, retourner false
        if (!empty($this->errors)) {
            return false;
        }
    
        // Hash du mot de passe
        $hashedPassword = password_hash($this->motdepasse_pro, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO proprietaire (nom_prop, prenom_prop, adresse_prop, cp_prop, tel_prop, login_prop, motdepasse_pro) 
                VALUES (:nom_prop, :prenom_prop, :adresse_prop, :cp_prop, :tel_prop, :login_prop, :motdepasse_pro)";
    
        try {
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':nom_prop', $this->nom_prop);
            $stmt->bindParam(':prenom_prop', $this->prenom_prop);
            $stmt->bindParam(':adresse_prop', $this->adresse_prop);
            $stmt->bindParam(':cp_prop', $this->cp_prop);
            $stmt->bindParam(':tel_prop', $this->tel_prop);
            $stmt->bindParam(':login_prop', $this->login_prop);
            $stmt->bindParam(':motdepasse_pro', $hashedPassword); // Utilisation du mot de passe haché
            $stmt->execute();
            $lastInsertedId = $this->maConnexion->lastInsertId();
            $this->numero_prop = $lastInsertedId; // Set the property with the retrieved ID
            return true; // Success of the insertion
        } catch (PDOException $e) {
            return false; // In case of error
        }
    }
    
    function redirigerAvecErreurs() {
        // Construire la chaîne de requête avec les erreurs
        $errorString = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $this->errors));
    
        // Utiliser la chaîne de requête avec les erreurs dans la redirection
        header("Location: ../vue/vue_inscription_proprietaire.php?" . $errorString);
        exit();
    }
    
    public function loginExiste($login_prop) {
        $requete = "SELECT COUNT(*) AS count FROM proprietaire WHERE login_prop = ?";
        $statement = $this->maConnexion->prepare($requete);
        $statement->execute([$login_prop]);
        $resultat = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultat['count'] > 0;
    }
    public function connexion_prop($login_prop, $motdepasse_pro) {
        try {
            $sql = "SELECT numero_prop, motdepasse_pro FROM proprietaire WHERE login_prop = :login_prop";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':login_prop', $login_prop);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && password_verify($motdepasse_pro, $result['motdepasse_pro'])) {
                $this->numero_prop = $result['numero_prop']; // Mettez à jour $this->numero_prop
                return $this->numero_prop; // Retourne l'ID (numero_prop) en cas d'authentification réussie
            } else {
                return false; // L'authentification a échoué
            }
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    }
    
    public function getProprietaireId($login, $motdepasse_pro) {
        // Appeler directement la méthode connexion_prop de l'instance courante
        return $this->connexion_prop($login, $motdepasse_pro);
    }
    public function getAppartementsProprietaire() {
        try {
            // Vérifiez d'abord si le numéro du propriétaire est défini
            if ($this->numero_prop) {
                $sql = "SELECT * FROM appartement WHERE numero_prop = :numero_prop";
                $stmt = $this->maConnexion->prepare($sql);
                $stmt->bindParam(':numero_prop', $this->numero_prop, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false; // Le numéro du propriétaire n'est pas défini
            }
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    }
    public function getDetailsProprietaireById($numero_prop) {
        try {
            $sql = "SELECT * FROM proprietaire WHERE numero_prop = :numero_prop";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':numero_prop', $numero_prop, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    
}
public function modifierPropriétaire($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_proprietaire_connecte) {
    echo "Paramètres reçus dans la méthode de la classe : ";
    var_dump($nouveauNom, $nouveauPrenom, $nouvelleAdresse, $nouveauCodePostal, $nouveauTelephone, $num_proprietaire_connecte);
    $connexionDB = new ConnexionDB();
    $maConnexion = $connexionDB->get_connexion();

    // Vérifiez d'abord si le numéro du propriétaire connecté est défini
    if ($num_proprietaire_connecte !== null) {
        // Construction de la requête SQL
        $sql = "UPDATE proprietaire SET ";
        $updateFields = array();

        // Ajoutez les champs à mettre à jour seulement s'ils sont fournis avec des valeurs non nulles
        if ($nouveauNom !== null) $updateFields[] = "nom_prop = :nouveauNom";
        if ($nouveauPrenom !== null) $updateFields[] = "prenom_prop = :nouveauPrenom";
        if ($nouvelleAdresse !== null) $updateFields[] = "adresse_prop = :nouvelleAdresse";
        if ($nouveauCodePostal !== null) $updateFields[] = "cp_prop = :nouveauCodePostal";
        if ($nouveauTelephone !== null) $updateFields[] = "tel_prop = :nouveauTelephone";

        $sql .= implode(", ", $updateFields);
        $sql .= " WHERE numero_prop = :num_proprietaire_connecte"; // Correction ici

        try {
            $stmt = $maConnexion->prepare($sql);

            // Ajoutez les liaisons de paramètres seulement pour les champs fournis avec des valeurs non nulles
            if ($nouveauNom !== null) $stmt->bindParam(':nouveauNom', $nouveauNom);
            if ($nouveauPrenom !== null) $stmt->bindParam(':nouveauPrenom', $nouveauPrenom);
            if ($nouvelleAdresse !== null) $stmt->bindParam(':nouvelleAdresse', $nouvelleAdresse);
            if ($nouveauCodePostal !== null) $stmt->bindParam(':nouveauCodePostal', $nouveauCodePostal);
            if ($nouveauTelephone !== null) $stmt->bindParam(':nouveauTelephone', $nouveauTelephone);

            // Ajoutez la liaison pour le numéro du propriétaire connecté
            $stmt->bindParam(':num_proprietaire_connecte', $num_proprietaire_connecte);

            $stmt->execute();

            // Modification réussie
            return true;
        } catch (PDOException $e) {
            // Affichez le message d'erreur spécifique
            error_log('Erreur de modification du propriétaire : ' . $e->getMessage());

            // En cas d'erreur, retournez false
            return false;
        }
    } else {
        // Si le numéro du propriétaire connecté n'est pas défini, retournez false
        return false;
    }
}






 
public static function supprimerProprietaire($numero_prop) {
    error_log("Function supprimerProprietaire called for numero_prop=" . $numero_prop);
    $connexionDB = new ConnexionDB();
    $pdo = $connexionDB->get_connexion();
    
    // SQL DELETE query with the correct table name
    $sql = "DELETE FROM proprietaire WHERE numero_prop = :numero_prop";
    
    // Prepare and execute the query
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':numero_prop', $numero_prop, PDO::PARAM_INT);
        $stmt->execute();

        // Return true for success
        return true;
    } catch (PDOException $e) {
        // Log the error
        error_log("Error deleting owner: " . $e->getMessage());
        
        // Throw an exception with the error message
        throw new Exception("Error deleting owner: " . $e->getMessage());
    }
}

public function getLoyerTotalParProprietaire($numero_prop) {
    $connexionDB = new ConnexionDB();
    $pdo = $connexionDB->get_connexion();
    
    try {
        $sql = "
        SELECT 
            p.numero_prop, 
            p.nom_prop, 
            p.prenom_prop, 
            l.nom_loc, 
            l.prenom_loc,
            a.num_appt,
            SUM(a.prix_loc + a.prix_charge) AS loyer_total,  -- Assurez-vous que cette colonne est présente
            SUM(a.prix_loc) AS prix_loyer,
            SUM(a.prix_charge) AS prix_charges
        FROM proprietaire p
        JOIN appartement a ON p.numero_prop = a.numero_prop
        JOIN locataire l ON a.num_appt = l.num_appt
        WHERE p.numero_prop = :numero_prop
        GROUP BY p.numero_prop, p.nom_prop, p.prenom_prop, l.nom_loc, l.prenom_loc, a.num_appt;
    ";
    

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':numero_prop', $numero_prop, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérez les erreurs ici si nécessaire
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

public function getAllProprietaire() {
    try {
        $connexionDB = new ConnexionDB();
        $maConnexion = $connexionDB->get_connexion();
        
        // Requête SQL pour récupérer tous les propriétaires
        $sql = "SELECT * FROM proprietaire";
        $stmt = $maConnexion->prepare($sql);
        $stmt->execute();
        $proprietaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Retournez les propriétaires récupérés
        return $proprietaires;
    } catch (PDOException $e) {
        // Gérez les exceptions ici
        return false;
    }
}
public function modifierProprietaireAdminmodele($numero_prop, $nom, $prenom, $adresse, $cp, $tel, $login) {
    $connexionDB = new ConnexionDB();
    $pdo = $connexionDB->get_connexion();
    
    try {
        // Prépare la requête SQL
        $sql = "UPDATE proprietaire SET nom_prop = ?, prenom_prop = ?, adresse_prop = ?, cp_prop = ?, tel_prop = ?, login_prop = ? WHERE numero_prop = ?";
        
        // Affichage de la requête SQL pour le débogage
        echo "Requête SQL : " . $sql . "<br>";

        $statement = $pdo->prepare($sql);

        // Lie les valeurs aux paramètres de la requête
        $statement->bindParam(1, $nom);
        $statement->bindParam(2, $prenom);
        $statement->bindParam(3, $adresse);
        $statement->bindParam(4, $cp);
        $statement->bindParam(5, $tel);
        $statement->bindParam(6, $login);
        $statement->bindParam(7, $numero_prop);

        // Affichage des valeurs des paramètres pour le débogage
        echo "Paramètres : ";
        var_dump([$nom, $prenom, $adresse, $cp, $tel, $login, $numero_prop]);

        // Exécute la requête
        $statement->execute();

        // Vérifie si la requête a réussi
        if ($statement->rowCount() > 0) {
            return true; // Modification réussie
        } else {
            return false; // Aucune modification effectuée
        }
    } catch (PDOException $e) {
        // Affichage de l'erreur pour le débogage
        echo "Erreur lors de la modification du propriétaire : " . $e->getMessage();
        throw new Exception("Erreur lors de la modification du propriétaire : " . $e->getMessage());
    }
}


public function getChiffreAffairesTotal() {
    $connexionDB = new ConnexionDB();
    $pdo = $connexionDB->get_connexion();
    
    try {
        $sql = "
        SELECT 
            SUM(a.prix_loc + a.prix_charge) AS loyer_total
        FROM appartement a;
    ";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['loyer_total']; // Retourne le chiffre d'affaires total pour tous les propriétaires
    } catch (PDOException $e) {
        // Gérez les erreurs ici si nécessaire
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}



}
// Vous n'avez pas besoin de cette accolade supplémentaire
?>
