<?php

include_once '..\php\urls.php';

 class StimaConsumoGas {

  private $persone;
 	private $dimensione;
 	private $potenzaAggiunta;

  private $tipologiaConsumo;

 	private $tabellaAgua;
 	private $tabellaCucina;
  private $tabellaRiscaldamento;


  public function __construct($obj) {
    $this->persone = $obj->personeSelected;
    $this->dimensione = $obj->dimensioneCasa;
    $this->tipologiaConsumo = $obj->tipologiaConsumo;
    $this->regione = $obj->regione;

    $this->setTabellaAgua();
    $this->setTabellaCucina();
    $this->setTabellaRiscaldamento();

  }

 	public function getConsumo() {
    $regione = $this->sceglieZona();

    if ($this->tipologiaConsumo) {
    }
 		
    $consumoRiscaldamento = $this->tabellaRiscaldamento[(string)$regione] * $this->dimensione;
    
    $consumoAgua = $this->tabellaAgua[(string)$this->persone];
    $consumoCucina = $this->tabellaCucina[(string)$this->persone];

    $consumo = $consumoRiscaldamento + $consumoAgua + $consumoCucina;

 		    return $consumo;
 	}


// ------ Set / Get

 	private function setTabellaAgua () {
 		$this->tabellaAgua = array(	
                        '1' => 70, 
					 							'2' => 130,
					 							'3' => 190,
					 							'4' => 250,
					 							'5' => 300,
					 							'6' => 370,
					 							'7' => 430	);
 	}

  private function setTabellaCucina () {
    $this->tabellaCucina = array( 
                        '1' => 50, 
                        '2' => 70,
                        '3' => 90,
                        '4' => 100,
                        '5' => 110,
                        '6' => 120,
                        '7' => 130  );
  }

  private function setTabellaRiscaldamento () {
    $this->tabellaRiscaldamento = array( 
                        '1' => 10.3, 
                        '2' => 10.3,
                        '3' => 8.8,
                        '4' => 8.8,
                        '5' => 4.1,
                        '6' => 4.1 );
  }



//------------------------------

  private function sceglieZona() {
      $dataDB = new DatabaseGas();

      $listaRegione = $dataDB->prendeTabella(DB_AZIENDE_GAS_REGIONE);
      $gruppo = 0;
      $regione = 1;

      foreach ($listaRegione as $value) {
        
          if ( in_array($this->regione, AdattaString::uscitaArray($value['regione'])) ) {
              $regione = $value['gruppo'];
              break;
          }
      }

      return $regione;
    }




 }