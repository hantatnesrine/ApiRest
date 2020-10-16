<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Controm-Allow-Headers, Authorization, X-Requested-With");

// on vérifie la methode
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
     //on inclut les fichiers de configuration et d'acces aux données
     include_once '../config/Database.php';
     include_once '../models/Tasks.php';
 
    //on instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    //instancier une tache
    $tache = new Tasks($db);

    // on récupère les informations envoyées

    $data = json_decode(file_get_contents("php://input"));
    var_dump($data);

    if(!empty($data->description))
    {
        $tache->description = $data->description;

        if($tache->ajout())
        {
            // ici la creation a fonctionné
            //code reponse 201 par ce c'est unre requete POST
            http_response_code(201);
            echo json_encode(["message"=>"L ajout a ete effectue"]);
        }
        else
        {
          // ici la creation n'a pas fonctionné
            //code reponse 201 par ce c'est unre requete POST
            http_response_code(503);
            echo json_encode(["message"=>"L ajout na pas ete effectue"]);  
        }
    }
}
else
{   
    http_response_code(405);
    echo json_encode(["message" => "La methode nest pas autorisee"]);
}

