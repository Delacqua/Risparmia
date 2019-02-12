<?php    

header("Content-Type: application/json");

    include_once(dirname(__FILE__) . '/urls.php');

    $dataDB = new DatabaseLuce();
    
    $tabella = substr($_SERVER['PATH_INFO'], 1); //correge lo string


     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     	$obj = json_decode(file_get_contents("php://input"));

        if ($obj->display) {
           $obj->display = 1;
        }
        else {
            $obj->display = 0;
        }
        
        if ($tabella == "utenteprivati") {
            $obj->nome = escapeString($obj->nome);
            $obj->cognome = escapeString($obj->cognome);
            $obj->telefono = escapeString($obj->telefono);
            $obj->fornitore = escapeString($obj->fornitore);
            $obj->commenti = escapeString($obj->commenti);

            $sql = "UPDATE $tabella SET 
                        nome='$obj->nome',
                        cognome='$obj->cognome',
                        telefono='$obj->telefono', 
                        fornitore='$obj->fornitore',
                        commenti='$obj->commenti',
                        display='$obj->display'
                    WHERE id='$obj->id'";

        }

        if ($tabella == "utenteiva") {

            $obj->ragionesociale = escapeString($obj->ragionesociale);
            $obj->telefono = escapeString($obj->telefono);
            $obj->commenti = escapeString($obj->commenti);

            $sql = "UPDATE $tabella SET 
                        ragionesociale='$obj->ragionesociale',
                        telefono='$obj->telefono', 
                        commenti='$obj->commenti',
                        display='$obj->display'
                    WHERE id='$obj->id'";
        }
     	

        $dataDB->aggiunge2($sql);
     }


 function escapeString ($string) {
    $stringEscape = mysql_real_escape_string($string);

        return $stringEscape;
 }
 