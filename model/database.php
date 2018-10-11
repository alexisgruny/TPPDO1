<?php
//création de la classe database
class database {
//liste des attributs
    protected $db;
    private $serverName = 'localhost';
    private $databaseName = 'webUser';
    private $username = 'user';
    private $password = 'pass';
    //déclaration de la méthode construct
    public function __construct() {
        //on test es erreurs avec try/catch
        //si tout est bon , on ce connecte a la base de donnée
        try {
            $this->db = new PDO('mysql:host=' . $this->serverName . ';dbname=' . $this->databaseName, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // attrape le message d'érreur si il y'en a une
        } catch (PDOException $error) {
            // renvois un message d'érreur a l'utilisateur
            die('Connection failed: ' . $error->getMessage());
        }
    }
}
?>
