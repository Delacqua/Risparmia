<?php
header("Content-Type: application/json");

/* Acceta appena le richieste interna del sito

$ref = $_SERVER['HTTP_REFERER'];

if($ref !== 'http://sito.... ') {
      http_response_code(401);
        throw new Exception('Access Not Allowed');
        exit;
}
*/

//Get a json from angular
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $tabella = substr($_SERVER['PATH_INFO'], 1); //correge lo string

//--------

include_once(dirname(__FILE__) . '/urls.php');

//-------------

// collega con il database

  $dataDB = new DatabaseLuce();
    

    $outp = array();
   
// Request from db
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $outpDB = $dataDB->prendeTabella($tabella);

      if (getTabella() === DB_AZIENDE_LUCE || getTabella() === DB_AZIENDE_IVA || getTabella() === DB_AZIENDE_LUCE_D || getTabella() === DB_AZIENDE_IVA_D) {
            $outp = construiciOggetto($outpDB, false, "AziendaDB");
      }

      if (getTabella() === DB_AZIENDE_GAS || getTabella() === DB_AZIENDE_GAS_IVA || getTabella() === DB_AZIENDE_GAS_D || getTabella() === DB_AZIENDE_GAS_IVA_D) {
            $outp = construiciOggetto($outpDB, false, "AziendaGasDB");
      }

   }


  // Request from site
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Prendi array aziende
        $outpDB = $dataDB->prendeTabella(getTabella());

        //Aziende Luce Privati / IVA
        if (getTabella() === DB_AZIENDE_LUCE || getTabella() === DB_AZIENDE_IVA) {
            $objConsumo = prendeConsumo("luce"); // Prendi il consumo
            $outp = construiciOggetto($outpDB, $objConsumo, "AziendaFornitori");
        }        

        //Aziende Gas Privati / IVA
        if (getTabella() === DB_AZIENDE_GAS || getTabella() === DB_AZIENDE_GAS_IVA) {
            $objConsumo = prendeConsumo("gas"); // Prendi il consumo
            $outp = construiciOggetto($outpDB, $objConsumo, "AziendaGasFornitori");
        }     

        //Seleziona azienda (luce) in primo piano (array) 
        if (getTabella() === DB_AZIENDE_LUCE_D || getTabella() === DB_AZIENDE_IVA_D) {
            $objConsumo = prendeConsumo("luce"); // Prendi il consumo
            $vetrina = Vetrina::seleziona($outpDB); // Seleziona azienda (randon)
            $outp = construiciOggetto($vetrina, $objConsumo, "AziendaVetrina");
        }
        
        //Seleziona azienda (luce) in primo piano (array) 
        if (getTabella() === DB_AZIENDE_GAS_D || getTabella() === DB_AZIENDE_GAS_IVA_D) {
            $objConsumo = prendeConsumo("gas"); // Prendi il consumo
            $vetrina = Vetrina::seleziona($outpDB); // Seleziona azienda (randon)
            $outp = construiciOggetto($vetrina, $objConsumo, "AziendaGasVetrina");
        }


    }


//------------- Risposta  -----------------------

    echo json_encode($outp); //output json

// -------------------------------



//Aziende privati / Aziende IVA
    function construiciOggetto($arrayDB, $objConsumo, $class) {
        $arr = array();

      // Construice l'oggetto e sceglie per regione
        foreach ($arrayDB as $key => $valore) {
            
            if ($objConsumo) { $azienda = new $class($valore, $objConsumo); }
            else { $azienda = new $class($valore); }
            
            $arr = selezionaRegione($azienda, $arr);
        }    

          return $arr;
    } 

//seleziona regione 
  function selezionaRegione($azienda,$array) {
        if (!isset(getRequest()->regione)) { array_push($array, $azienda); return $array; }

        if (in_array(getRequest()->regione, $azienda->getRegione())) {
              array_push($array, $azienda);
        }

          return $array;
    } 


//Oggeto consumo - 
    function prendeConsumo ($tipo) {
        if ($tipo == "luce") {
            $consumo = new Consumo(getRequest()); // ->consumo, ->array [f1, f2, f3], ->potenza
        }
        if ($tipo == "gas") {
            $consumo = new ConsumoGas(getRequest()); // ->consumo
        }
        
              return $consumo;
    }


// ------ get / set
    function getRequest () {
        global $request;
          return $request;
    }

    function getTabella () {
        global $tabella;
          return $tabella;
    }

