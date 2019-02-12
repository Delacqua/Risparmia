<?php
// Create connection to database and return a json 
header("Content-Type: application/json");

    include_once(dirname(__FILE__) . '/urls.php');

    $dataDB = new DatabaseLuce();

//Deprecated
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $tabella = substr($_SERVER['PATH_INFO'], 1); //correge lo string
        $outp = $dataDB->prendeTabella($tabella);

        http_response_code(400);
        echo json_encode($outp);
    }
//------

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

        $idx = substr($_SERVER['PATH_INFO'], 1); //Correge string
        parse_str($_SERVER['QUERY_STRING'], $tabella);
        $dataDB->delete($tabella['tabella'],$idx);

    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

        $data = json_decode(file_get_contents("php://input"));
        $tabella = $data->tabella;
        $nome = $data->item;

        switch ($tabella) {
            case DB_SERVIZI_AGG:
                $row = 'serviziagg'; 
                break;
            case DB_FATTURAZIONE:
                $row = 'fatturazione'; 
                break;
            default:
                $row = $tabella;
                break;
        }


        $sql = "INSERT INTO $tabella ($row) VALUES ('$nome')";

        $id = $dataDB->aggiunge2($sql);

        echo json_encode($id);

    }

?>