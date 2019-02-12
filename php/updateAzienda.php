<?php 

$input = json_decode(file_get_contents("php://input"));

    include_once(dirname(__FILE__) . '/urls.php');

    $dataDB = new DatabaseLuce();


	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		$idx = substr($_SERVER['PATH_INFO'], 1); //Correge string
		parse_str($_SERVER['QUERY_STRING'], $tabella);
	    $dataDB->delete($tabella['tabella'],$idx);
	}

	else {
		    $data = $input->item;
		    $tabella = $input->tabella;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dataDB->aggiornaTabella2(SqlUpdate::sqlUpdateDB($tabella,$data));
		}

		if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
			$dataDB->aggiunge2(SqlPost::sqlPostDB($tabella,$data));
		}

	}


?>