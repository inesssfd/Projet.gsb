<?php
include_once '..\controleur\param_connexion.php';

class Locataire {
    private $num_loc;
    private $nom_loc;
    private $prenom_loc;
    private $date_nais;
    private $tel_loc;
    private $num_bancaire;
    private $nom_banque;
    private $cp_banque;
    private $tel_banque;
    private $login_loc;
    private $motdepasse_loc;
    private $num_appt;
    
    private $maConnexion;

    public function __construct(
        $nom_loc = '?', $prenom_loc = '?', $date_nais = '?',
        $tel_loc = '?', $num_bancaire = '?', $nom_banque = '?',
        $cp_banque = '?', $tel_banque = '?', $login_loc = '?',
        $motdepasse_loc = '?', $num_appt = null
    ) {
        $this->nom_loc = $nom_loc;
        $this->prenom_loc = $prenom_loc;
        $this->date_nais = $date_nais;
        $this->tel_loc = $tel_loc;
        $this->num_bancaire = $num_bancaire;
        $this->nom_banque = $nom_banque;
        $this->cp_banque = $cp_banque;
        $this->tel_banque = $tel_banque;
        $this->login_loc = $login_loc;
        $this->motdepasse_loc = $motdepasse_loc;
        $this->num_appt = $num_appt;

        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }
    public function getnum_loc() {
        return $this->num_loc;
    }

    public function getnum_appt() {
        return $this->num_appt;
    }

    public function getLoginLoc() {
        return $this->login_loc;
    }

    public function gemotdepasse_loct() {
        return $this->motdepasse_loc;
    }

    public function gettel_loc() {
        return $this->tel_loc;
    }

    public function getNum_bancaire() {
        return $this->num_bancaire;
    }
    public function getCp_banque() {
        return $this->cp_banque;
    }
    public function getTel_banque() {
        return $this->tel_banque;
    }
         


    public function connexion($login_loc, $motdepasse_loc)
    {
        try {
            $sql = "SELECT motdepasse_loc FROM locataire WHERE login_loc = :login_loc";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':login_loc', $login_loc);
            $stmt->execute();
            $hashedPassword = $stmt->fetchColumn();
    
            if ($hashedPassword && password_verify($motdepasse_loc, $hashedPassword)) {
                return true; // Authentification réussie
            } else {
                return false; // Échec de l'authentification
            }
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    }
    
    public function getIdByLogin($login_loc) {
        try {
            $sql = "SELECT num_loc FROM locataire WHERE login_loc = :login_loc";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':login_loc', $login_loc);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['num_loc'] ?? null;
        } catch (PDOException $e) {
            return null; // Handle exceptions here
        }
    }

    public function getAppartementsLocataire($login_loc)
    {
        try {
            // Sélectionnez les appartements associés au locataire
            $sql = "SELECT * FROM appartement WHERE num_appt IN (SELECT num_appt FROM locataire WHERE login_loc = :login_loc)";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':login_loc', $login_loc);
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
            return null; // Retourne null en cas d'erreur
        }
    }
    
    public function inscription()
    {
        try {
            // Hash du mot de passe
            $hashedPassword = password_hash($this->motdepasse_loc, PASSWORD_DEFAULT);
    
            // Votre requête SQL d'insertion ici
            $sql = "INSERT INTO locataire (nom_loc, prenom_loc, date_nais, tel_loc, num_bancaire, nom_banque, cp_banque, tel_banque, login_loc, motdepasse_loc, num_appt) 
                    VALUES (:nom_loc, :prenom_loc, :date_nais, :tel_loc, :num_bancaire, :nom_banque, :cp_banque, :tel_banque, :login_loc, :motdepasse_loc, :num_appt)";
            
            $stmt = $this->maConnexion->prepare($sql);
    
            // Liens entre les paramètres et les propriétés de l'objet
            $stmt->bindParam(':nom_loc', $this->nom_loc);
            $stmt->bindParam(':prenom_loc', $this->prenom_loc);
            $stmt->bindParam(':date_nais', $this->date_nais);
            $stmt->bindParam(':tel_loc', $this->tel_loc);
            $stmt->bindParam(':num_bancaire', $this->num_bancaire);
            $stmt->bindParam(':nom_banque', $this->nom_banque);
            $stmt->bindParam(':cp_banque', $this->cp_banque);
            $stmt->bindParam(':tel_banque', $this->tel_banque);
            $stmt->bindParam(':login_loc', $this->login_loc);
            $stmt->bindParam(':motdepasse_loc', $hashedPassword); // Utilisation du mot de passe haché
            $stmt->bindParam(':num_appt', $this->num_appt);
    
            // Exécution de la requête
            $stmt->execute();
    
            // Vérifiez si l'insertion a réussi
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Gérez les exceptions ici (par exemple, en les enregistrant dans un fichier de journal)
            return false;
        }
    }
    
public function getDetailslocataireById($num_loc) {
    try {
        $sql = "SELECT * FROM locataire WHERE num_loc = :num_loc";
        $stmt = $this->maConnexion->prepare($sql);
        $stmt->bindParam(':num_loc', $num_loc, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
        throw new DetailsLocataireException("Erreur lors de la récupération des détails du locataire.", 0, $e);
    }
    }
    public function modifierLocataire($num_loc, $nom_loc, $prenom_loc, $date_nais, $tel_loc) {
        try {
            // Votre requête SQL pour la mise à jour ici
            $sql = "UPDATE locataire SET nom_loc = :nom_loc, prenom_loc = :prenom_loc, tel_loc = :tel_loc, date_nais = :date_nais  WHERE num_loc = :num_loc";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':nom_loc', $nom_loc);
            $stmt->bindParam(':prenom_loc', $prenom_loc);
            $stmt->bindParam(':tel_loc', $tel_loc);
            $stmt->bindParam(':num_loc', $num_loc);
            $stmt->bindParam(':date_nais', $date_nais);
            // Exécution de la requête
            $stmt->execute();
    
            // Vérifiez si la mise à jour a réussi
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Gérez les exceptions ici
            return false;
        }
    }
 
// Dans votre classe Locataire
public function supprimerLocataire($num_loc) {
    try {
        // Votre requête SQL pour la suppression ici
        $sql = "DELETE FROM locataire WHERE num_loc = :num_loc";
        $stmt = $this->maConnexion->prepare($sql);
        $stmt->bindParam(':num_loc', $num_loc);

        // Exécution de la requête
        $stmt->execute();

        // Vérifiez si la suppression a réussi
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        // Gérez les exceptions ici
        return false;
    }
}



}
?>
