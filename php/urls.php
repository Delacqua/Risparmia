<?php
//luce
const DB_AZIENDE_LUCE = 'sito_aziendeluce';
const DB_AZIENDE_LUCE_D = 'sito_aziendelucedestaque';
const DB_AZIENDE_IVA = 'sito_aziendeluce';
//const DB_AZIENDE_IVA = 'sito_aziendeluceiva';
const DB_AZIENDE_IVA_D = 'sito_aziendelucedestaque';
const DB_ACCISA = 'sito_accisa';
const DB_IVA = 'sito_iva';
const DB_ALTRE_TASSE = 'sito_altritasse';
const DB_ELLETRO = 'sito_elettrodomestici';

//gas
const DB_AZIENDE_GAS = 'sito_aziendegas';
const DB_AZIENDE_GAS_D = 'sito_aziendegasdestaque';
const DB_AZIENDE_GAS_IVA = 'sito_aziendegas';
//const DB_AZIENDE_GAS_IVA = 'sito_aziendegasiva';
const DB_AZIENDE_GAS_IVA_D = 'sito_aziendegasdestaque';
const DB_AZIENDE_GAS_REGIONE = 'sito_regionegas';
const DB_ACCISA_GAS = 'sito_accisagas';
const DB_IVA_GAS = 'sito_ivagas';
const DB_ALTRE_TASSE_GAS = 'sito_altritassegas';
const DB_ELLETRO_GAS = 'sito_elettrodomesticigas';
const DB_TRANSPORTO_GAS = 'sito_transportogas';
const DB_FASCIA_TRANSPORTO_GAS = 'sito_fasciagas';

//comune
const DB_SERVIZI_AGG = 'sito_serviziagg';
const DB_FATTURAZIONE = 'sito_fatturazione';
const DB_REGIONE = 'sito_regione';
const DB_COMUNE = 'sito_comune';

//utenti
const DB_UTENTE_PRIVATI = 'sito_utenteprivati';
const DB_UTENTE_IVA = 'sito_utenteiva';
const DB_UTENTE_RICHIAMA = 'sito_utenterichiama';




//-------------------------------- load all classes 

function __autoload($className) { 

	$cartelle = array(
            dirname(__FILE__).'/',
            dirname(__FILE__).'/gas/',
            dirname(__FILE__).'/luce/'
        );

	foreach($cartelle as $cartella) {
	    if (file_exists($cartella.$className . '.php')) { 
	        require_once $cartella.$className . '.php'; 
	          return true; 
	    } 
	}
	   	return false; 
}

/*
function __autoload($className) { 
      if (file_exists($className . '.php')) { 
          require $className . '.php'; 
          return true; 
      } 
      return false; 
}
*/
//---------------------------------