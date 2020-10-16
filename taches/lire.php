<?php 

//headers requis

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Controm-Allow-Headers, Authorization, X-Requested-With");


if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    //on inclut les fichiers de configuration et d'acces aux données
    include_once '../config/Database.php';
    include_once '../models/Tasks.php';

    //on instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    //instancier une tache
    $tache = new Tasks($db);

    //recuperer les données
    $stmt = $tache->lire();

    //on verifie si on a au moins une tache
    if($stmt->rowCount() > 0)
    {
        // on iniialise un tabelau associatif
        $tabTaches = [];
        $tabTaches['taches'] = [];
        
        // on parcours les taches
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

//var_dump($row);

            $tach = [
                "id" => $row['id'],
                "description" => htmlentities($description) 
            ];

            $tabTaches['taches'][] = $tach; 
        }
        //on envoie le code réponse OK
        http_response_code(200);
        //on encore la reponse en json
        echo json_encode($tabTaches);

    }

}else
{   
    
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisée"]);
}
