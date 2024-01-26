<?php
class ConnexionDB 
{
    // Informations de connexion
    private  $dbHost = 'localhost';
	private  $dbName = 'location_gsb';
    private  $dbUser = 'root';
    private  $dbPassword = '';
	private $maConnexion; // devrait être "statique" => voir étapes suivantes


    public function __construct() // crée la connexion
    {
        // Data Source Name
        $dsn = 'mysql:dbname='. $this->dbName . ';host=' . $this->dbHost;

        // On appelle le constructeur de la classe PDO
        try
		{
            $this->maConnexion = new PDO ($dsn, $this->dbUser, $this->dbPassword );
			$this->maConnexion->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
			$this->maConnexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->maConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

        }
		catch(PDOException $e) // si erreur de connexion
		{
            die($e->getMessage());
        }
    }

	public function get_connexion()
	{
		return $this->maConnexion;
	}
}