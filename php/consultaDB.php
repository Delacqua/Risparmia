<?php
// Create connection to database and return a json 
header("Content-Type: application/json");

    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);

    include_once(dirname(__FILE__) . '/urls.php');
//    include_once(dirname(__FILE__) . '/Database.php');
//    include_once(dirname(__FILE__) . '/luce/DatabaseLuce.php');
    

    $dataDB = new DatabaseLuce();
    $tabella = substr($_SERVER['PATH_INFO'], 1); //correge lo string
    $outp = $dataDB->prendeTabella($tabella); 

    if ($tabella == DB_COMUNE) {
        $outp = utf8ize($outp);
    }

    if ($tabella == DB_ELLETRO || $tabella == DB_ELLETRO_GAS) {
        $outp = aggiustaElletro($outp);
    }

    if ($tabella == DB_REGIONE) {
        $outp = aggiustaRegione($outp);
    }

    if ($tabella == DB_UTENTE_PRIVATI || $tabella == DB_UTENTE_IVA) {
        $outp = aggiustaData($outp);
    }
    
    if ($tabella == DB_AZIENDE_GAS_REGIONE) {
        $outp = aggiustaRegioneGas($outp);
    }

//------------- Risposta  -----------------------

    echo json_encode($outp); //output json

// -----------------------------------------------


    function aggiustaElletro ($arrayInput) {
        $arrayOutp = array();

        foreach ($arrayInput as $key => $value) {
            if ($value['selezionato']) {
                    $value['selezionato'] = true;
            }
                else {
                    $value['selezionato'] = false;
                }

            $obj = (object) ['selezionato' => $value['selezionato'],'nome' =>$value['nome']]; 
            array_push($arrayOutp,$obj);            
        }

            return $arrayOutp;
    }

    function aggiustaRegione ($arrayInput) {
        $arrayOutp = array();

        foreach ($arrayInput as $key => $value) {
           array_push($arrayOutp, $value['nome']);
        }

        return array_unique($arrayOutp);
    }

    function aggiustaData ($arrayInput) {
        foreach ($arrayInput as $key => $value) {
            $result = DateTime::createFromFormat('Y-m-d H:i:s', $value['data']);
            $result = $result->format('d-m');
            $arrayInput[$key]['data'] = $result;
        }

        return $arrayInput;
    }

    function aggiustaRegioneGas ($arrayInput) {
        $arrayOutp = array();

        foreach ($arrayInput as $value) {
           array_push($arrayOutp, AdattaString::uscitaArray($value['regione']));
        }

        return $arrayOutp;
    }
    

//correge caractere 
    function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } 
        else if (is_string ($d)) {
            return utf8_encode($d);
            }
            return $d;
    }