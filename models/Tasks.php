<?php
class Tasks
{
    //connexion 
    private $connexion;
    private $table = "tasks";

    //objet proprties
    public $id;
    public $description;
    
    // constructeur avec $bd pour la connexion à la base

    public function __construct($db)
    {
        $this->connexion = $db;
    }

    // lecture des taches
    public function lire()
    {
        //requete sql
         $sql = "select * from " . $this->table ;
         // preparer la requete
        $query = $this->connexion->prepare($sql);
        //executer la requete
        $query->execute();
        //on retourne le resultat de la requete
        return $query;
    }

    //ajouter une tache
    public function ajout()
    {
        //requete sql d'ajout
        $sql = "insert into ". $this->table . " SET description=:description";
        // preparer la requete
        $query = $this->connexion->prepare($sql);
        
        // Protection contre les injections 
        $this->description=htmlspecialchars((strip_tags($this->description)));

        // Ajout des données protégées
        $query->bindParam(":description", $this->description);

        //Execution de la requete
        if ($query->execute()){
            return true;
        }
        return false;
    }

    //supprimer une tache

    public function supprimer()
    {
        // on ecrit la requete
        $sql = "delete from " . $this->table . " Where id = ?";

        // on prepare la requete
        $query = $this->connexion->prepare($sql);

        // on sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));

        // on attache l'id
        $query->bindParam(1, $this->id);

        // on excute la requete
        if($query->execute())
        {
            return true;
        }
        return false;

    }
    public function modifier()
    {
        //requete sql d'ajout
        $sql = "update ". $this->table . " SET description = :description where id = :id";
        
        // preparer la requete
        $query = $this->connexion->prepare($sql);
        
        // Protection contre les injections 
        $this->description=htmlspecialchars((strip_tags($this->description)));

        // Ajout des données protégées
        $query->bindParam(":id", $this->id);
        $query->bindParam(":description", $this->description);

        //Execution de la requete
        if ($query->execute()){
            return true;
        }
        return false;
    }
   
}
