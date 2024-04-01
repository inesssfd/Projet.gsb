<?php
include_once '..\controleur\param_connexion.php';
class demande {
    private $id_demandes_location ;
	private $num_demandeur ;
	private $num_appt;
	private $date_demande;
	private $etat_demande;
    private $maConnexion;
	
    public function __construct($id_demandes_location='?', $num_demandeur='?', $num_appt='?', $date_demande='?', $etat_demande='?')
    {
        // Ne pas définir num_demandeur ici
        $this->id_demandes_location = $id_demandes_location;
        $this->num_demandeur = $num_demandeur;
        $this->num_appt = $num_appt;
        $this->date_demande = $date_demande;
        $this->etat_demande = $etat_demande;
    
        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }

public function getid_demandes_location() {
    return $this->id_demandes_location;
}
public function getnum_demandeur() {
    return $this->num_demandeur;
}

public function getnum_appt() {
    return $this->num_appt;
}

public function getdate_demande() {
    return $this->date_demande;
}
public function getetat_demande() {
    return $this->etat_demande;
}

public function insererDemande() {
    $requete = "INSERT INTO demandes_location (num_demandeur, num_appt, date_demande, etat_demande)
                VALUES (:num_demandeur, :num_appt, :date_demande, :etat_demande)";
    $statement = $this->maConnexion->prepare($requete);
    $resultat = $statement->execute([
        'num_demandeur' => $this->num_demandeur,
        'num_appt' => $this->num_appt,
        'date_demande' => $this->date_demande,
        'etat_demande' => $this->etat_demande
    ]);
    return $resultat;
}

public static function getDemandesByDemandeur($num_demandeur) {
    $connexionDB = new ConnexionDB();
    $connexion = $connexionDB->get_connexion();
    $requete = "SELECT * FROM demandes_location WHERE num_demandeur = :num_demandeur";
    $statement = $connexion->prepare($requete);
    $statement->execute(['num_demandeur' => $num_demandeur]);
    $resultat = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
public static function getDemandesByAppartement($num_appt) {
    $connexionDB = new ConnexionDB();
    $connexion = $connexionDB->get_connexion();
    $requete = "SELECT * FROM demandes_location WHERE num_appt = :num_appt";
    $statement = $connexion->prepare($requete);
    $statement->execute(['num_appt' => $num_appt]);
    $resultat = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
public function updateetat_demande($etat_demande, $id_demandes_location) {
    // Mettre à jour l'état de la demande dans la base de données avec la date actuelle
    $requete = "UPDATE demandes_location SET etat_demande = :etat_demande, date_demande = NOW() WHERE id_demandes_location = :id_demandes_location";
    $statement = $this->maConnexion->prepare($requete);
    $resultat = $statement->execute([
        'etat_demande' => $etat_demande,
        'id_demandes_location' => $id_demandes_location
    ]);
    return $resultat;
}



public static function getDemandeByDemandeurAndAppt($num_demandeur, $num_appt) {
    $connexionDB = new ConnexionDB();
    $connexion = $connexionDB->get_connexion();
    $requete = "SELECT * FROM demandes_location WHERE num_demandeur = :num_demandeur AND num_appt = :num_appt";
    $statement = $connexion->prepare($requete);
    $statement->execute(['num_demandeur' => $num_demandeur, 'num_appt' => $num_appt]);
    $resultat = $statement->fetch(PDO::FETCH_ASSOC);
    return $resultat;
}

public static function supprimeDemande($id_demandes_location) {
    try {
        // Connexion à la base de données
        $connexionDB = new ConnexionDB();
        $connexion = $connexionDB->get_connexion();
        
        // Requête de suppression
        $requete = "DELETE FROM demandes_location WHERE id_demandes_location = :id_demandes_location";
        $statement = $connexion->prepare($requete);
        
        // Exécution de la requête
        $statement->execute(['id_demandes_location' => $id_demandes_location]);

        // Vérification du succès de la suppression
        if ($statement->rowCount() > 0) {
            // Suppression réussie
            return true;
        } else {
            // Aucune ligne n'a été supprimée
            return false;
        }
    } catch (PDOException $e) {
         echo $e->getMessage(); // Pour afficher le message d'erreur
        return false;
    } finally {
        // Fermeture de la connexion à la base de données
        $connexion = null;
    }
}





}