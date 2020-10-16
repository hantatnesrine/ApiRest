<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Controm-Allow-Headers, Authorization, X-Requested-With");

// on vérifie la methode
if($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
     //on inclut les fichiers de configuration et d'acces aux données
     include_once '../config/Database.php';
     include_once '../models/Tasks.php';
 
    //on instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    //instancier une tache
    $tache = new Tasks($db);

    // on recupere l'id du produit

    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->id))
    {
        $tache->id = $data->id;

        if($tache->supprimer())
        {
            // Ici la suppression a fonctionnée
            // on envoie un code 200
            http_response_code(200);
            echo json_encode (["message" => "La suppression a bien fonctionne"]);
        }
        else
        {
            //Ici la suppression n'a pas fonctionnée
            //on envoie un code 503
            http_response_code(["message" => "La suppression na pas ete effectuee"]);
        }
    }
}
else
{   
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisée"]);
}