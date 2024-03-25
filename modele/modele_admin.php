<?php
include_once '../controleur/param_connexion.php';
class Admin {
    private $admin_id;
    private $username;
    private $password;
    private $email;
    private $maConnexion;

    public function __construct( $admin_id='?', $username='?', $password='?', $email='?') {
        $this->admin_id = $admin_id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;

        $connexionDB = new ConnexionDB();
        $this->maConnexion = $connexionDB->get_connexion();
    }
    public function getAdminId() {
        return $this->admin_id;
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM admins WHERE username = :username AND password = :password";
            $stmt = $this->maConnexion->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return true; // Authentification réussie
            } else {
                return false; // Échec de l'authentification
            }
        } catch (PDOException $e) {
            return false; // Gérez les exceptions ici
        }
    }
}