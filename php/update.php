<?php

//--------

include_once (dirname(__FILE__) . '/urls.php');

//-------------

 //   $dataDB = new DatabaseLuce();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $tabella = $data->tabella;
        $obj = $data->item;
        
        $db = DatabaseUtente::getInstance();
        $mysqli = $db->getConnection(); 

        if ($tabella==DB_UTENTE_PRIVATI) {
            $_comune = $mysqli->real_escape_string($obj->comune);
            $_regione = $mysqli->real_escape_string($obj->regione);
            $_nome = $mysqli->real_escape_string($obj->nome);
            $_cognome = $mysqli->real_escape_string($obj->cognome);
            $_telefono = $mysqli->real_escape_string($obj->telefono);
                if (isset($obj->email)) { $_email = $mysqli->real_escape_string($obj->email); }
                else { $_email = "Senza Email"; }

            $sql = "INSERT INTO $tabella (comune, regione, nome, cognome, telefono, email, accetta) 
            VALUES ('$_comune', '$_regione', '$_nome', '$_cognome', '$_telefono', '$_email', '1')";

        }

        if ($tabella==DB_UTENTE_IVA) {
            $_comune = $mysqli->real_escape_string($obj->comune);
            $_regione = $mysqli->real_escape_string($obj->regione);
            $_ragioneSociale = $mysqli->real_escape_string($obj->ragioneSociale);
            $_telefono = $mysqli->real_escape_string($obj->telefono);
                if (isset($obj->email)) { $_email = $mysqli->real_escape_string($obj->email); }
                else { $_email = "Senza Email"; }
            
            $sql = "INSERT INTO $tabella (comune, regione, ragioneSociale, telefono, email, accetta) 
            VALUES ('$_comune', '$_regione', '$_ragioneSociale', '$_telefono', '$_email', '1')";
        }

        if ($tabella==DB_UTENTE_RICHIAMA) {
            if (isset($obj->tipo)) {
                $_nome = $mysqli->real_escape_string($obj->nome);
                $_cognome = $mysqli->real_escape_string($obj->cognome);
                $_telefono = $mysqli->real_escape_string($obj->telefono);
                $_email = $mysqli->real_escape_string($obj->email);
                $_tipo = $mysqli->real_escape_string($obj->tipo);


                $sql = "INSERT INTO $tabella (nome, cognome, telefono, email, commenti, accetta) 
                VALUES ('$_nome', '$_cognome', '$_telefono', '$_email', '$_tipo', '1')";

            }
                else {
                    $_telefono = $mysqli->real_escape_string($obj->telefono);

                    $sql = "INSERT INTO $tabella (nome, cognome, telefono, accetta) 
                    VALUES ('Utente', 'Richiamare', '$_telefono', '1')";
                }

        }


        if ($mysqli->query($sql)) {
            $id = $mysqli->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        email($obj, $tabella, $id);

    }


//Email con i nuovi utenti
function email($dati,$tabella,$id) {
    //server smtp
    ini_set('SMTP', 'mail.azmarketing.it'); 
    ini_set('smtp_port', 25);


    //Il mensaggio
    if ($tabella==DB_UTENTE_PRIVATI) {
        $msg = "Nome: " . $dati->nome . "\n" . "Cognome: " . $dati->cognome . "\n" . "Comune: " . $dati->comune . "\n" . "Regione: " . $dati->regione . "\n" .
        "Telefono: " . $dati->telefono . "\n" . "E-mail: " . $dati->email ;
    }
      
    if ($tabella==DB_UTENTE_IVA) {
        $msg = "Ragione Sociale: " . $dati->ragioneSociale . "\n" . "Comune: " . $dati->comune . "\n" . "Regione: " . $dati->regione . "\n" . "Telefono: " . $dati->telefono
        . "E-mail: " . $dati->email ;
    }

    if ($tabella==DB_UTENTE_RICHIAMA) {
        if (isset($dati->tipo)) {
            $msg = "Utente Richiamare, " . "Nome: " . $dati->nome . "\n" . "Cognome: " . $dati->cognome . "\n" . "Telefono: " . $dati->telefono . "\n" . "E-mail: " . $dati->email . "Luce o Gas: " . $dati->tipo ;
        }
            else {
                $msg = "Utente Richiamare, " . "Telefono: " . $dati->telefono;
            }
        
    }

    // if lines are longer than 70 characters
    $msg = wordwrap($msg,70);


    $to = "fabricio@azmarketing.it";
    $subject = "Nuovo Utenti";
    $headers = "From:fabricio@azmarketing.it";

    // Sending email
    if(mail($to,$subject,$msg,$headers)){
        echo "email";
    } else{
        echo 'fail';
    }

}