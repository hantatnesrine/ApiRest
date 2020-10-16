<?php
class Database
{
    //connexion à la base de données
    private $host = "localhost:3308";
    private $db_name = "todo";
    private $username = "root";
    private $password = "";
    public $connexion;
    //getter pour la connexion
    public function getConnection()
    {
        $this->connexion = null;
        try
        {
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->exec("set names utf8");
        }
    catch(PDOException $e)
    {
        echo "Erreur de connexion :" . $e->getMessage();
    }
    return $this->connexion;
    }
}