<?php

const DB_AZIENDE_LUCE = 'aziendeluce';
const DB_AZIENDE_LUCE_D = 'aziendelucedestaque';
const DB_AZIENDE_IVA = 'aziendeluceiva';
const DB_AZIENDE_IVA_D = 'aziendelucedestaque';
const DB_UTENTE_PRIVATI = 'utenteprivati';
const DB_UTENTE_IVA = 'utenteiva';
const DB_SERVIZI_AGG = 'serviziagg';
const DB_FATTURAZIONE = 'fatturazione';
const DB_REGIONE = 'regione';
const DB_ELLETRO = 'elettrodomestici';
const DB_COMUNE = 'comune';
const DB_ACCISA = 'accisa';
const DB_IVA = 'iva';
const DB_ALTRE_TASSE = 'altritasse';


//--------------------------------

function __autoload($className) {

    if (file_exists($className . '.php')) { 
        require_once $className . '.php'; 
    	     return true; 
    }

	     return false; 
}

//include_once "..\php\AdattaString.php";
//include_once "..\php\gas\DatabaseGas.php";

//---------------------------------