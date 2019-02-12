<?php
// Create connection to database and return a json 
header("Content-Type: application/json");

    include_once(dirname(__FILE__) . '/urls.php');

    $dataDB = new DatabaseLuce();

//Deprecated
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $outpA = $dataDB->prendeTabella(DB_ACCISA);
        $outpT = $dataDB->prendeTabella(DB_ALTRE_TASSE);
        $outpI = $dataDB->prendeTabella(DB_IVA);


        $outp = array('accisa' => $outpA, 'altritasse' => $outpT, 'iva' => $outpI );

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
        $obj = $data->item;

        $sql = SqlPut::sqlPutDB($tabella,$obj);

        $dataDB->aggiornaTabella2($sql);

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $tabella = $data->tabella;
        $obj = $data->item;

        $sql = SqlPost::sqlPostDB($tabella,$obj);

        $id = $dataDB->aggiunge2($sql);

        json_encode($id);

    }

